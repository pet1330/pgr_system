<?php

namespace App\Http\Controllers;

use Log;
use Bouncer;
use Validator;
use DataTables;
use Carbon\Carbon;
use MediaUploader;
use App\Models\Media;
use App\Models\Staff;
use App\Models\Student;
use App\Models\Approval;
use App\Models\Milestone;
use Illuminate\Http\Request;
use App\Models\MilestoneType;
use App\Models\StudentRecord;
use App\Http\Requests\ApprovalRequest;
use App\Http\Requests\MilestoneRequest;
use App\Notifications\AdminUploadAlert;
use App\Notifications\StudentUploadAlert;
use App\Notifications\AdminUploadConfirmation;
use App\Notifications\StudentUploadConfirmation;
use App\Notifications\StudentMilestoneApprovalAlert;
use App\Notifications\SupervisorMilestoneApprovalAlert;

class MilestoneController extends Controller
{
    public function index(Student $student, StudentRecord $record)
    {
        $this->authorise('view', $student);

        if ($student->id !== $record->student_id) {
            abort(404);
        }

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
                'overdue', 'submitted', 'upcoming', 'future', 'awaiting', 'approved'));
    }

    public function overdue(Request $request)
    {

        // permissions checked in data function

        if ($request->ajax()) {
            return $this->data(Milestone::select('milestones.*')->overdue())->make(true);
        }

        return view('admin.milestone.list', [
            'title' => 'Overdue Milestones',
            'subtitle' => 'All overdue milestones',
            ]);
    }

    public function amendments(Request $request)
    {

        // permissions checked in data function

        if ($request->ajax()) {
            return $this->data(Milestone::select('milestones.*')->awaitingAmendments())
        ->make(true);
        }

        return view('admin.milestone.list', [
            'title' => 'Awaiting Amendments',
            'subtitle' => 'All milestones awaiting amendments',
            ]);
    }

    public function upcoming(Request $request)
    {

        // permissions checked in data function

        if ($request->ajax()) {
            return $this->data(Milestone::select('milestones.*')->upcoming())->make(true);
        }

        return view('admin.milestone.list', [
            'title' => 'Upcoming Milestones',
            'subtitle' => 'All upcoming milestones',
            ]);
    }

    public function submitted(Request $request)
    {

        // permissions checked in data function

        if ($request->ajax()) {
            return $this->data(Milestone::select('milestones.*')->underReview())
                ->editColumn('submitted_date', function (Milestone $ms) {
                    return $ms->submitted_date->format('d/m/Y').
                           ' ('.$ms->submitted_date->diffForHumans().')';
                })
                ->filterColumn('submitted_date', function ($query, $keyword) {
                    $keyword = implode('%%', str_split(str_replace(['+', '-'], '',
                        filter_var($keyword, FILTER_SANITIZE_NUMBER_INT)
                    )));
                    $query->whereRaw("DATE_FORMAT(submitted_date,'%d/%m/%Y') like ?",
                        ["%%$keyword%%"]);
                })->make(true);
        }

        return view('admin.milestone.list', [
            'title' => 'Submitted Milestones',
            'subtitle' => 'All submitted milestones',
            'show_submitted' => true,
            ]);
    }

    public function recent(Request $request)
    {

        // permissions checked in data function

        if ($request->ajax()) {
            return $this->data(Milestone::select('milestones.*')->recentlySubmitted())
                ->editColumn('submitted_date', function (Milestone $ms) {
                    return $ms->submitted_date->format('d/m/Y').
                           ' ('.$ms->submitted_date->diffForHumans().')';
                })
                ->filterColumn('submitted_date', function ($query, $keyword) {
                    $keyword = implode('%%', str_split(str_replace(['+', '-'], '',
                        filter_var($keyword, FILTER_SANITIZE_NUMBER_INT)
                    )));
                    $query->whereRaw("DATE_FORMAT(submitted_date,'%d/%m/%Y') like ?",
                        ["%%$keyword%%"]);
                })->make(true);
        }

        return view('admin.milestone.list', [
            'title' => 'Submitted Milestones',
            'subtitle' => 'Recently submitted milestones',
            'show_submitted' => true,
            ]);
    }

    public function data($milestones)
    {
        $this->authorise('view', Milestone::class);

        return Datatables::eloquent($milestones->with([
            'type', 'student', 'student.student', 'student.school',
        ]))
            ->editColumn('school', function (Milestone $ms) {
                return $ms->student->school->name;
            })
            ->editColumn('name', function (Milestone $ms) {
                return $ms->name;
            })
            ->editColumn('due_date', function (Milestone $ms) {
                return $ms->due_date->format('d/m/Y').'  ('.
                $ms->due_date->diffForHumans().')';
            })
            ->editColumn('first_name', function (Milestone $ms) {
                return $ms->student->student->first_name;
            })
            ->editColumn('last_name', function (Milestone $ms) {
                return $ms->student->student->last_name;
            })
            ->filterColumn('due_date', function ($query, $keyword) {
                $keyword = implode('%%', str_split(str_replace(['+', '-'], '',
                    filter_var($keyword, FILTER_SANITIZE_NUMBER_INT)
                )));
                $query->whereRaw("DATE_FORMAT(due_date,'%d/%m/%Y') like ?", ["%%$keyword%%"]);
            })
            ->setRowAttr(['data-link' => function (Milestone $ms) {
                return route('student.record.milestone.show', [
                            $ms->student->student->university_id,
                            $ms->student->slug(),
                            $ms->slug(),
                        ]);
            },
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Student $student, StudentRecord $record)
    {
        if ($student->id !== $record->student_id) {
            abort(404);
        }

        $this->authorise('view', $student);
        $this->authorise('createMilestone');

        $types = auth()->user()->can('manage', Milestone::class) ?
            MilestoneType::all() : MilestoneType::studentMakable()->get();

        return view('admin.milestone.create', compact('student', 'record', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Student $student, StudentRecord $record)
    {
        if ($student->id !== $record->student_id) {
            abort(404);
        }

        $this->authorise('view', $student);

        $milestone = auth()->user()->can('manage', Milestone::class) ?
            $this->storeAdminMilestone($request, $student, $record) :
            $this->storeStudentMilestone($request, $student, $record);

        if ($milestone instanceof Milestone) { // else redirect is returned
            $student->allow('view', $milestone);
            $student->allow('upload', $milestone);
            Bouncer::refreshFor($student);
            $record->supervisors->each(function (Staff $supervisor) use ($milestone) {
                $supervisor->allow('view', $milestone);
                Bouncer::refreshFor($supervisor);
            });

            return redirect()->route('student.record.milestone.show',
                compact('student', 'record', 'milestone'));
        }

        return $milestone;
    }

    private function storeStudentMilestone(Request $request,
        Student $student, StudentRecord $record)
    {
        $validator = Validator::make($request->all(), [
            'milestone_type' => ['required', 'exists:milestone_types,id,student_makable,1'],
            'file' => ['required', 'max:20000'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $m = Milestone::make([
            'due_date' => Carbon::now()->format('Y-m-d'),
            'milestone_type_id' => $request->milestone_type,
            'created_by' => auth()->id(),
            ]);

        $m->submitted_date = $m->due_date;
        $away_days = $student->interuptionPeriodSoFar();
        $m->non_interuptive_date = Carbon::parse($m->due_date)->subDays($away_days);
        $milestone = $record->timeline()->save($m);

        try {
            $media = MediaUploader::fromSource($request->file('file'))
                ->useHashForFilename()
                ->toDestination('local', 'milestone-attachments/'.$milestone->slug())
                ->upload();
            $media->original_filename = $request->file('file')->getClientOriginalName();
            $media->uploader_id = auth()->id();
            $media->save();

            if ($media->exists()) {
                $milestone->attachMedia($media, ['submission']);
                $milestone->save();

                return $milestone;
            }
        } catch (MediaUploadException $e) {
        } catch (\Exception $ex) {
        }

        $milestone->forceDelete();
        $validator->errors()->add('file', 'The attached file is invalid.');

        return redirect()->back()->withErrors($validator)->withInput();
    }

    private function storeAdminMilestone(Request $request,
        Student $student, StudentRecord $record)
    {
        $this->authorise('manage', Milestone::class);

        $validator = Validator::make($request->all(), [
            'milestone_type' => ['required', 'exists:milestone_types,id'],
            'due' => ['date'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $m = Milestone::make([
            'due_date' => $request->due,
            'milestone_type_id' => $request->milestone_type,
            'non_interuptive_date' => Carbon::parse($request->due)->subDays($student->interuptionPeriodSoFar()),
            'created_by' => auth()->id(),
            ]);

        $milestone = $record->timeline()->save($m);

        return $milestone;
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

        if ($record->id != $milestone->student_record_id) {
            abort(404);
        }

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
        $this->authorise('manage', $milestone);

        if ($record->id != $milestone->student_record_id) {
            abort(404);
        }

        $types = MilestoneType::all();

        return view('admin.milestone.edit',
            compact('student', 'record', 'milestone', 'types'));
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
        $this->authorise('manage', $milestone);

        if ($record->id !== $milestone->student_record_id) {
            abort(404);
        }

        $away_days = $student->interuptionPeriodSoFar(Carbon::parse($request->due));
        $milestone->due_date = $request->due;
        $milestone->milestone_type_id = $request->milestone_type;
        $milestone->non_interuptive_date = Carbon::parse($request->due)->subDays($away_days);
        $milestone->save();

        return redirect()->route('student.record.milestone.show',
            compact('student', 'record', 'milestone'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student, StudentRecord $record, Milestone $milestone)
    {
        $this->authorise('manage', $milestone);

        // We are using soft delete so this item will remain in the database
        $milestone->delete();

        return redirect()
            ->route('student.record.milestone.index',
                [$student->university_id, $record->slug()])
            ->with('flash', [
                'message' => 'Successfully deleted "'.$milestone->name.'"',
                'type' => 'success',
            ]);
    }

    public function upload(Request $request,
        Student $student, StudentRecord $record, Milestone $milestone)
    {
        $this->authorise('upload', $milestone);

        if ($milestone->student_record_id !== $record->id ||
            $student->id !== $record->student_id) {
            abort(404);
        }

        if ($milestone && $request->file('file') !== null) {
            $media = MediaUploader::fromSource($request->file('file'))
                ->useHashForFilename()
                ->toDestination('local', 'milestone-attachments/'.$milestone->slug())
                ->upload();
            $media->original_filename = $request->file('file')->getClientOriginalName();
            $media->uploader_id = auth()->id();
            $media->save();
            $milestone->attachMedia($media, ['submission']);
            $milestone->submitted_date = Carbon::now();
            $milestone->save();
            $this->sendUploadNotifications($student, $record, $milestone, $media);

            return 'File uploaded successfully';
        }
        abort(404);
    }

    public function sendUploadNotifications(
        Student $student, StudentRecord $record, Milestone $milestone, Media $upload)
    {
        $details = [$student, $record, $milestone, $upload];

        if ($upload->uploader->id === $student->id) { // If the student uploads
            //  confirm student
            $student->notify(new StudentUploadConfirmation(...$details));
            //  alert school
            $record->school->notify(new AdminUploadAlert(...$details));
        } elseif ($record->school->notifications_address == $upload->uploader->university_email) { // If school uploads
            //  alert school
            $record->school->notify(new AdminUploadAlert(...$details));
            //  alert student
            $student->notify(new StudentUploadAlert(...$details));
        } else { // If neither
            //  Confirm uploader
            $upload->uploader->notify(new AdminUploadConfirmation(...$details));
            //  alert student
            $student->notify(new StudentUploadAlert(...$details));
            //  alert school
            $record->school->notify(new AdminUploadAlert(...$details));
        }

        if ($record->directorOfStudy) {
            $record->directorOfStudy->notify(new AdminUploadAlert(...$details));
        } elseif ($record->secondSupervisor) {
            $record->secondSupervisor->notify(new AdminUploadAlert(...$details));
        } elseif ($record->thirdSupervisor) {
            $record->thirdSupervisor->notify(new AdminUploadAlert(...$details));
        }
    }

    public function download(Request $request,
        Student $student, StudentRecord $record, Milestone $milestone, Media $file)
    {
        $this->authorise('view', $milestone);

        if ($file->fileExists()) {
            return response()->download($file->getAbsolutePath(), $file->original_filename);
        }
        Log::error('Uploaded file '.$file->slug().' appears to be out of sync');
        abort(401);
    }

    public function approve(ApprovalRequest $request,
        Student $student, StudentRecord $record, Milestone $milestone)
    {
        $this->authorise('manage', Approval::class);

        if ((bool) $request->approved) {
            $student->disallow('upload', $milestone);
        } else {
            $student->allow('upload', $milestone);
        }

        Bouncer::refreshFor($student);

        $approval = $milestone->approve($request->approved, $request->feedback);

        $student->notify(new StudentMilestoneApprovalAlert($student,
            $record, $milestone, $approval));

        $record->supervisors->each->notify(new SupervisorMilestoneApprovalAlert($student,
            $record, $milestone, $approval));

        return redirect()->route('student.record.milestone.show',
          [$student->university_id, $record->slug(), $milestone->slug()])
            ->with('flash', [
                'message' => 'Successfully approved milestone',
                'type' => 'success',
            ]);
    }
}
