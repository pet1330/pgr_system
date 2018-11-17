<?php

namespace App\Console\Commands;

use App\Models\Milestone;
use App\Models\MilestoneType;
use Illuminate\Console\Command;
use App\Models\MilestoneTemplate;

class MergeMilestoneTypes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pgr:mergemilestonetypes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Merge Two Milestone Types';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->question('This process will attempted to merge two Milestone Types into one.    ');
        $this->question('It is **highly recommend** that you take a backup before continuing   ');
        $this->question('as this can be a potentially hazardous task in which data may be lost.');

        if (! $this->confirm('Are you sure you want to continue?')) {
            return;
        }

        if ($types_c = MilestoneType::withTrashed()->count() < 2) {
            $this->error('This process requires at least two Milestone Types (System contains '.$types_c.')');

            return;
        }

        $m_types = MilestoneType::withTrashed()->pluck('name');

        $mt_new = MilestoneType::where('name',
                $this->choice('Choose the Milestone that you wish to merge (and keep)', $m_types->toArray())
            )->withTrashed()->first() ?? dd($this->error('This milestone type could not be found.'));

        $mt_old = MilestoneType::where('name',
                $this->choice('Choose the Milestone you wish to merge with (to replace)',
                    $m_types->filter(function ($name) use ($mt_new) {
                        return $name != $mt_new->name;
                    })->toArray()
                ))->withTrashed()->first() ?? dd($this->error('This milestone type could not be found.'));

        $this->info('Updating Milestones with type: '.$mt_new->name);
        Milestone::withTrashed()
            ->whereIn('id', Milestone::where('milestone_type_id', $mt_new->id)->withTrashed()->pluck('id'))
            ->update(['milestone_type_id' => $mt_old->id]);

        $this->info('Updating Milestone Types with type: '.$mt_new->name);
        MilestoneTemplate::withTrashed()
            ->whereIn('id', MilestoneTemplate::where('milestone_type_id', $mt_new->id)->withTrashed()->pluck('id'))
            ->update(['milestone_type_id' => $mt_old->id]);

        $this->info('Deleting Milestone Type '.$mt_new->name);
        $mt_new->forceDelete();

        $this->info('Renaming Milestone Type from '.$mt_old->name.' to '.$mt_new->name);
        $mt_old->update(['name' => $mt_new->name]);

        $mt_old->restore();
    }
}
