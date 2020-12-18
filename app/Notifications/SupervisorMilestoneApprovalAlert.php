<?php

namespace App\Notifications;

use App\Models\Approval;
use App\Models\Milestone;
use App\Models\Student;
use App\Models\StudentRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SupervisorMilestoneApprovalAlert extends Notification implements ShouldQueue
{
    use Queueable;

    public $record;
    public $student;
    public $milestone;
    public $approval;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Student $student,StudentRecord $record,
        Milestone $milestone, Approval $approval)
    {
        $this->record = $record;
        $this->student = $student;
        $this->milestone = $milestone;
        $this->approval = $approval;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = route('student.record.milestone.show', [$this->student->university_id,
            $this->record->slug(), $this->milestone->slug(), ]);

        $status = $this->approval->approved ? 'Approved' : 'Revisions requested';
        $lineOne = sprintf("This email is to inform %s's milestone '%s' has been assess and given the status '%s'.",
            $this->student->name, $this->milestone->name, $status);
        $lineTwo = '';

        if (! $this->approval->approved) { // if rejected
            $lineOne .= ' They will be required to amend the documentation and submit an updated version.';
            if ($this->approval->reason) {
                $lineTwo .= sprintf('The following feedback was provided: %s. ', str_finish($this->approval->reason, '.'));
            }
            $lineTwo .= sprintf(
                'Please ensure %s understands the alterations that must be made. For further clarification, please liaise with the PGR admin team.', $this->student->first_name);
        }

        return (new MailMessage)
            ->line($lineOne)
            ->line($lineTwo)
            ->action('View Milestone', $url)
            ->line('Thanks!')
            ->subject(sprintf('Milestone %s: %s [%s]', $this->student->name, $this->milestone->name, strtoupper($status)));
    }
}
