# Roles of Users in the PGR System

Currently, the system supports different core roles for users:

## Student

The default user for any user signing in with a university student account (determined by the central account type), an example is a user with the email address `12345678@students.lincoln.ac.uk`

### Permissions

Students can

* view their own milestones
* view their own timeline
* create new optional milestones of types enabled for student creation
* view their supervisor and contact details
* view their profile
* submit documents to milestones 

### Notifications

Students are notified by email when:

* one of their [PGR milestones](milestone) is __upcoming__ (notification is sent `N` days before due date, where `N` is the configured `duration` of a milestone, see [PGR milestones](milestone) for details.
* one of their [PGR milestones](milestone) is __due__ (notification is sent _on_ the due date of the milestone.
* one of their [PGR milestones](milestone) is `approved` or `rejected` (requiring amendments)
* they have  submitted a document to a milestone on their behalf (confirmation email)
* somebody else (Admin) has submitted a document to a milestone on their behalf



***

## Staff

The default user for any user signing in with a university staff account (determined by the central account type), an example is a user with the email address `auser@lincoln.ac.uk`.

By default, staff can be assigned to be a supervisor (1st, 2nd or 3rd) of any student. If they are assigned supervisor status to a student they see those student's details, timeline, and milestones, and also receive reminders and notifications about all their supervised students. A member of staff who is not a supervisor can log in, but does not see any information in the system by default.

### Permissions

Staff can

* view their supervised students' [PGR milestones](milestone)
* view their supervised students' timeline
* view their supervised students' submissions

### Notifications

Staff are notified by email when:

* one of their supervised students' [PGR milestones](milestone) is __upcoming__ (notification is sent `N` days before due date, where `N` is the configured `duration` of a milestone, see [PGR milestones](milestone) for details.
* one of their supervised students' [PGR milestones](milestone) is __due__ (notification is sent _on_ the due date of the milestone.
* one of their supervised students' [PGR milestones](milestone) is `approved` or `rejected` (requiring amendments)
* a document is submitted to a milestone (by student or admin).

### Special Role: Viewing Staff

_A view-only role can be given to staff who need to view all student records and milestones of students, e.g. panel members and PGR leads. These are provided on a case by case basis following a request to the [reporting system](https://gitreports.com/issue/LCAS/pgr_system/) and eligibility checks. The `view-only` role effectively provides the same rights as an admin, but restricts this to read-only._

## Admin

The Admin role is reserved to specifically trained members of staff who are given permission to create and amend student records, manage the milestones and the approval processes. Usually, there is a designated admin person in each school and a manager on college level. Admins are manually created by "promoting" regular staff accounts to admins.

### Permissions

Admins can

* view, create and amend all student records
* view, create and amend all milestone records
* create and delete interruptions
* submit on behalf of students
* approve or decline any student's submissions

### Notifications

Admins themselves are not notified on an individual basis, however, one email address is configured per school, which receives the following notifications by email when:

* one of their schools' students' [PGR milestones](milestone) is __upcoming__ (notification is sent `N` days before due date, where `N` is the configured `duration` of a milestone, see [PGR milestones](milestone) for details.
* one of their schools' students' [PGR milestones](milestone) is __due__ (notification is sent _on_ the due date of the milestone.
* one of their schools' students' [PGR milestones](milestone) is `approved` or `rejected` (requiring amendments)
* a document is submitted to a milestone (by student or admin) of one of their schools' students.

## Super-Admin

This is a special role for the college PGR manager, it allows new [Timeline Template](template), types of [PGR Milestones](milestone), and other statuses to be added to the system. 