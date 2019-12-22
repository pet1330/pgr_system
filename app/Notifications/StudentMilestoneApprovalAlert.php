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

        $status = $this->approval->approved ? 'approved' : 'rejected';
        $lineTwo = '';

        $lineOne = sprintf("This email is to inform you that your milestone '%s' has been %s.",
            $this->milestone->name, $status);

        if (! $this->approval->approved) { // if rejected
            $lineOne .= ' You will be required to amend your documentation and submit an updated version.';
            if ($this->approval->reason) {
                $lineTwo .= sprintf('The following feedback was provided: %s. ', str_finish($this->approval->reason, '.'));
            }
            $lineTwo .= 'Please liaise with your PGR admin team for further clarification.';
        }

        return (new MailMessage)
            ->line($lineOne)
            ->line($lineTwo)
            ->action('View Milestone', $url)
            ->line('Thanks!')
            ->subject(sprintf('Milestone %s: %s', strtoupper($status), $this->milestone->name));
    }
}
