<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use MediaUploader;
use App\Models\Student;
use App\Models\Milestone;
use Illuminate\Http\Request;
use App\Models\MilestoneType;
use App\Models\StudentRecord;
use App\Http\Controllers\Controller;
use App\Http\Requests\MilestoneRequest;
use Yajra\Datatables\Facades\Datatables;
use App\Notifications\MilestoneUpload;


class MilestoneController extends Controller
{

    public function index(Student $student, StudentRecord $record)
    {

        $this->authorise('view', $student);

        if($student->id !== $record->student_id) abort(404);

        $milestones = $record->timeline;
        $recently_submitted = $milestones->filter->isRecentlySubmitted();
        $overdue = $milestones->filter->isOverdue();
        $submitted = $milestones->filter->isPreviouslySubmitted();
        $upcoming = $milestones->filter->isUpcoming();
        $future = $milestones->filter->isFuture();
        $awaiting = $milestones->filter->isAwaitingAmendments();
        $approved = $milestones->filter->isApproved();

        return View('student.milestones', 
            compact('student', 'record', 'milestones', 'recently_submitted',
                'overdue', 'submitted', 'upcoming', 'future', 'awaiting', 'approved') );
    }

    public function overdue(Request $request)
    {

        $this->authorise('view', Milestone::class);

        if ($request->ajax())
            return $this->data( Milestone::overdue() )->make(true);

        return view('admin.milestone.list', [
            'title' => 'Overdue Milestones',
            'subtitle' => 'All overdue milestones',
            ]);
    }

    public function upcoming(Request $request)
    {

        $this->authorise('view', Milestone::class);

        if ($request->ajax())
            return $this->data( Milestone::upcoming() )->make(true);

        return view('admin.milestone.list', [
            'title' => 'Upcoming Milestones',
            'subtitle' => 'All upcoming milestones',
            ]);
    }

    public function submitted(Request $request)
    {

        $this->authorise('view', Milestone::class);

        if ($request->ajax())
        {
            return $this->data( Milestone::submitted() )
                ->editColumn('submitted_date', function (Milestone $ms)
                { 
                    return $ms->submitted_date->format('d/m/Y') .
                           ' (' . $ms->submitted_date->diffForHumans() . ')';
                })
                ->filterColumn('submitted_date', function ($query, $keyword) {
                    $keyword = implode('%%',str_split(str_replace( ['+', '-'], '',
                        filter_var($keyword, FILTER_SANITIZE_NUMBER_INT)
                    )));
                    $query->whereRaw("DATE_FORMAT(submitted_date,'%d/%m/%Y') like ?", ["%%$keyword%%"]);
                })
                ->make(true);
        }

        return view('admin.milestone.list', [
            'title' => 'Submitted Milestones',
            'subtitle' => 'All submitted milestones',
            'show_submitted' => true,
            ]);
    }

    public function data($milestones)
    {

        $this->authorise('view', Milestone::class);

        return Datatables::eloquent($milestones->with('type', 'student', 'student.student'))
            ->editColumn('type', function (Milestone $ms)
                { return $ms->name; })
            ->editColumn('due_date', function (Milestone $ms)
                { return $ms->due_date->format('d/m/Y') . '  ('.$ms->due_date->diffForHumans().')' ; })
            ->editColumn('first_name', function (Milestone $ms)
                { return $ms->student->student->first_name; })
            ->editColumn('last_name', function (Milestone $ms)
                { return $ms->student->student->last_name; })
            ->filterColumn('due_date', function ($query, $keyword) {
                $keyword = implode('%%',str_split(str_replace( ['+', '-'], '',
                    filter_var($keyword, FILTER_SANITIZE_NUMBER_INT)
                )));
                $query->whereRaw("DATE_FORMAT(due_date,'%d/%m/%Y') like ?", ["%%$keyword%%"]);
            })
            ->setRowAttr([ 'data-link' => function(Milestone $ms)
                {
                    return route('admin.student.record.show',
                        [$ms->student->student->university_id, $ms->student->slug(),]
                    );
                }
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Student $student, StudentRecord $record)
    {

        $this->authorise('create', Milestone::class);
        $this->authorise('view', $student);

        if ($student->id !== $record->student_id) abort(404);

        $types = MilestoneType::all();
        return view('admin.milestone.create', compact('student', 'record', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MilestoneRequest $request, Student $student, StudentRecord $record)
    {

        $this->authorise('create', Milestone::class);
        $this->authorise('view', $student);

        if ($student->id !== $record->student_id) abort(404);

        $away_days = $student->interuptionPeriodSoFar(Carbon::parse($request->due));
        $milestone = $record->timeline()->save(
            Milestone::make([
                'due_date' => $request->due,
                'milestone_type_id' => $request->milestone_type,
                'non_interuptive_date' => Carbon::parse($request->due)->subDays($away_days),
                'created_by' => auth()->id(),
            ])
        );
        return redirect()->route('admin.student.record.milestone.show', compact('student', 'record', 'milestone'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student, StudentRecord $record, Milestone $milestone)
    {

        $this->authorise('view', $milestone);

        if ($record->id != $milestone->student_record_id) abort(404);

        return view('admin.milestone.show', compact('student', 'record', 'milestone'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student, StudentRecord $record, Milestone $milestone)
    {

        $this->authorise('update', $milestone);

        if ($record->id != $milestone->student_record_id) abort(404);

        $types = MilestoneType::all();
        return view('admin.milestone.edit', compact('student', 'record', 'milestone', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MilestoneRequest $request,
        Student $student, StudentRecord $record, Milestone $milestone)
    {

        $this->authorise('update', $milestone);

        if ($record->id !== $milestone->student_record_id) abort(404);

        $away_days = $student->interuptionPeriodSoFar(Carbon::parse($request->due));
        $milestone->due_date = $request->due;
        $milestone->milestone_type_id = $request->milestone_type;
        $milestone->non_interuptive_date = Carbon::parse($request->due)->subDays($away_days);
        $milestone->save();
        return redirect()->route('admin.student.record.milestone.show', compact('student', 'record', 'milestone'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student, StudentRecord $record, Milestone $milestone)
    {

        $this->authorise('delete', $milestone);

        // We are using soft delete so this item will remain in the database
        $milestone->delete();
        return redirect()
            ->route('admin.student.record.milestone.index', [$student->university_id, $record->slug()])
            ->with('flash', 'Successfully deleted "' . $milestone->name . '"');
    }

    public function upload(Request $request,
        Student $student, StudentRecord $record, Milestone $milestone)
    {

        $this->authorise('upload', $milestone);

        if($milestone && $request->file( 'file' ) !== null )
        {
            session()->flash("files", 1);
            $media = MediaUploader::fromSource( $request->file( 'file' ) )
                ->useHashForFilename()
                ->toDestination( 'public', 'milestone-attachments/' . $milestone->slug() )
                ->upload();
            $media->original_filename = $request->file( 'file' )->getClientOriginalName();
            $media->uploader_id = auth()->id();
            $media->save();
            $milestone->attachMedia($media, ['submission']);
            $milestone->submitted_date = Carbon::now();
            $milestone->save();
            $student->notify( new MilestoneUpload( $student, $record, $milestone, $media ) );
            return "File uploaded successfully";
        }
        abort(404);
    }


    public function download(Request $request,
        Student $student, StudentRecord $record, Milestone $milestone, Media $file)
    {

        $this->authorise('view', $milestone);

        if($file->fileExists())
            return response()->download($file->contents());
        Log::error('Uploaded file ' . $file->slug() . " appears to be out of sync");
        abort(404);
    }

    public function approve(Request $request,
        Student $student, StudentRecord $record, Milestone $milestone)
    {
        // $this->authorise('upload', $milestone);

        $milestone->approve($request->approved, $request->feedback);

        return redirect()->route('admin.student.record.milestone.show',
          [$student->university_id, $record->slug(), $milestone->slug()])
        ->with('flash', 'Successfully approved milestone"');
    }
}
