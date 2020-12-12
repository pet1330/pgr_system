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

class StudentMilestoneApprovalAlert extends Notification implements ShouldQueue
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
        $lineOne = '';
        $lineTwo = '';

        if ($this->approval->approved) { // if approved
            $lineOne = sprintf(
                "This email is to inform you that your submitted milestone documentation for '%s' has been approved. Well done!",
                $this->milestone->name
            );
        } else {
            $lineOne = sprintf(
                "This email is to inform you that your submitted milestone documentation for '%s' could not be fully approved in its current form. You will be required to amend your documentation and submit an updated version as soon as possible.",
                $this->milestone->name
            );
        }
        if ($this->approval->reason) {
            $lineTwo .= sprintf(
                'The following additional feedback was provided: %s. ',
                str_finish($this->approval->reason, '.')
            );
        }
        $lineTwo .= ' Please liaise with your PGR admin team and your supervisors for further clarification.';

        return (new MailMessage)
            ->line($lineOne)
            ->line($lineTwo)
            ->action('View Milestone', $url)
            ->line('Thanks!')
            ->subject(sprintf('Milestone %s: %s', $this->milestone->name, $status));
    }
}
