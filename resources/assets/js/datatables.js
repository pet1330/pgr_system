$(document).ready(function() {

    let generalSettings = {
        serverSide: true,
        processing: true,
        language: {
            "processing": '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
            },
        ajax: window.location.href,
        info: true,
        // stateSave: true,
        bProcessing: true,
        deferRender: false,
        lengthMenu: [[10, 20, 30, 40, 50, 100, 200, 500], [10, 20, 30, 40, 50, 100, 200, 500]],
        dom: 'lfrtBip',
        buttons: [
            { extend: 'copy', exportOptions: { columns: ':visible' } },
            { extend: 'excel', exportOptions: { columns: ':visible' } },
            { extend: 'pdf', exportOptions: { columns: ':visible' } },
            { extend: 'print', exportOptions: { columns: ':visible' } },
            'colvis'
        ]
    }
    // LIST OF ALL STUDENTS FOR ADMINS
    // ==========================================================================
    $('#admin-student-table').DataTable(
        _.merge({}, generalSettings, {
            columns: [
                { data: 'first_name', name: 'student.first_name', searchable: true, orderable: true },
                { data: 'last_name', name: 'student.last_name', searchable: true, orderable: true },
                { data: 'university_id', name: 'student.university_id', searchable: true, orderable: true },
                { data: 'school', name: 'school.name', searchable: true, orderable: true },
                { data: 'tierFour', name: 'tierFour', searchable: true, orderable: true },
                { data: 'fundingType', name: 'fundingType.name', searchable: true, orderable: true },
                { data: 'modeOfStudy', name: 'modeOfStudy.name', searchable: true, orderable: true },
                { data: 'programme', name: 'programme.name', searchable: true, orderable: true },
                { data: 'enrolmentStatus', name: 'enrolmentStatus.status', searchable: true, orderable: true },
                { data: 'studentStatus', name: 'studentStatus.status', searchable: true, orderable: true }

            ]
        })
    );

    // List of Admins for Admins
    //==============================================================================================
    $('#admin-admin-table').DataTable(
        _.merge({}, generalSettings, {
            columns: [
                { data: 'first_name', name: 'first_name', searchable: true, orderable: true },
                { data: 'last_name', name: 'last_name', searchable: true, orderable: true },
                { data: 'university_id', name: 'university_id', searchable: true, orderable: true }
            ]
        })
    );

    // List of absence types for Admins
    //==============================================================================================
    $('#admin-absence-type-table').DataTable(
        _.merge({}, generalSettings, {
            "searching": false,
            columns: [
                { data: 'name', name: 'name', searchable: false, orderable: false },
                { data: 'interuption', name: 'interuption', searchable: false, orderable: false },
                { data: 'currentabsence_count', name: 'currentabsence_count', searchable: false, orderable: false },
                { data: 'absence_count', name: 'absence_count', searchable: false, orderable: false },
                { data: 'editaction', name: 'editaction', orderable: false, searchable: false },
                { data: 'deleteaction', name: 'deleteaction', orderable: false, searchable: false }
            ]
        })
    );

    // List of funding types for Admins
    //==============================================================================================
    $('#admin-funding-type-table').DataTable(
        _.merge({}, generalSettings, {
            "searching": false,
            columns: [
                { data: 'name', name: 'name', searchable: false, orderable: false },
                { data: 'students_count', name: 'students_count', searchable: false, orderable: false },
                { data: 'editaction', name: 'editaction', orderable: false, searchable: false },
                { data: 'deleteaction', name: 'deleteaction', orderable: false, searchable: false }
            ]
        })
    );

    // List of programmes for Admins
    //==============================================================================================
    $('#admin-programme-table').DataTable(
        _.merge({}, generalSettings, {
            "searching": false,
            columns: [
                { data: 'name', name: 'name', searchable: false, orderable: false},
                { data: 'duration', name: 'duration', searchable: false, orderable: false},
                { data: 'students_count', name: 'students_count', searchable: false, orderable: false},
                { data: 'editaction', name: 'editaction', orderable: false, searchable: false},
                { data: 'deleteaction', name: 'deleteaction', orderable: false, searchable: false}
            ]
        })
    );

    // Modes of study for Admins
    //==============================================================================================
    $('#admin-mode-of-study-table').DataTable(
        _.merge({}, generalSettings, {
            "searching": false,
            columns: [
                { data: 'name', name: 'name', searchable: false, orderable: false},
                { data: 'timing_factor', name: 'timing_factor', searchable: false, orderable: false},
                { data: 'students_count', name: 'students_count', searchable: false, orderable: false},
                { data: 'editaction', name: 'editaction', orderable: false, searchable: false},
                { data: 'deleteaction', name: 'deleteaction', orderable: false, searchable: false}
            ]
        })
    );

    // List of student statuses for Admins
    //==============================================================================================
    $('#admin-student-status-table').DataTable(
        _.merge({}, generalSettings, {
            "searching": false,
            columns: [
                { data: 'status', name: 'status', searchable: false, orderable: false},
                { data: 'students_count', name: 'students_count', searchable: false, orderable: false},
                { data: 'editaction', name: 'editaction', orderable: false, searchable: false},
                { data: 'deleteaction', name: 'deleteaction', orderable: false, searchable: false}
            ]
        })
    );


    // List of enrolment statuses for Admins
    //==============================================================================================
    $('#admin-enrolment-status-table').DataTable(
        _.merge({}, generalSettings, {
            "searching": false,
            columns: [
                { data: 'status', name: 'status', searchable: false, orderable: false},
                { data: 'students_count', name: 'students_count', searchable: false, orderable: false},
                { data: 'editaction', name: 'editaction', orderable: false, searchable: false},
                { data: 'deleteaction', name: 'deleteaction', orderable: false, searchable: false}
            ]
        })
    );

    // List of milestone types for Admins
    //==============================================================================================
    $('#admin-milestone-type-table').DataTable(
        _.merge({}, generalSettings, {
            "searching": false,
            columns: [
                { data: 'name', name: 'name', searchable: false, orderable: false },
                { data: 'duration', name: 'interuption', searchable: false, orderable: false },
                { data: 'student_makable', name: 'student_makable', searchable: false, orderable: false },
                { data: 'milestones_count', name: 'milestones_count', searchable: false, orderable: false },
                { data: 'milestone_templates_count', name: 'milestone_templates_count', searchable: false, orderable: false },
                { data: 'editaction', name: 'editaction', orderable: false, searchable: false },
                { data: 'deleteaction', name: 'deleteaction', orderable: false, searchable: false }
            ]
        })
    );

    // List of timeline templates for Admins
    //==============================================================================================
    $('#admin-timeline-template-table').DataTable(
        _.merge({}, generalSettings, {
            "searching": false,
            columns: [
                { data: 'name', name: 'name', searchable: false, orderable: false },
                { data: 'milestone_templates_count', name: 'milestone_templates_count', searchable: false, orderable: false },
                { data: 'editaction', name: 'editaction', orderable: false, searchable: false },
                { data: 'deleteaction', name: 'deleteaction', orderable: false, searchable: false }
            ]
        })
    );

    // List of milestones for Admins
    //==============================================================================================
    $('#admin-milestones-table').DataTable(
        _.merge({}, generalSettings, {
            "searching": false,
            columns: [
                { data: 'name', name: 'milestone_type.name', searchable: true, orderable: true },
                { data: 'due_date', name: 'due_date', searchable: true, orderable: true },
                { data: 'first_name', name: 'student_record.student.first_name', searchable: false, orderable: false },
                { data: 'last_name', name: 'student_record.student.last_name', searchable: false, orderable: false },
            ]
        })
    );

    // List of submitted milestones for Admins
    //==============================================================================================
    $('#admin-submitted-milestones-table').DataTable(
        _.merge({}, generalSettings, {
            "searching": false,
            columns: [
                { data: 'name', name: 'milestone_type.name', searchable: true, orderable: true },
                { data: 'due_date', name: 'due_date', searchable: true, orderable: true },
                { data: 'submitted_date', name: 'submitted_date', searchable: true, orderable: true },
                { data: 'first_name', name: 'student_record.student.first_name', searchable: false, orderable: false },
                { data: 'last_name', name: 'student_record.student.last_name', searchable: false, orderable: false },
            ]
        })
    );

    // List of milestone templates for Admins
    //==============================================================================================
    $('#admin-milestone-template-table').DataTable(
        _.merge({}, generalSettings, {
            columns: [
                { data: 'name', name: 'milestone_type.name', searchable: true, orderable: true },
                { data: 'due', name: 'due', searchable: true, orderable: true },
                { data: 'editaction', name: 'editaction', orderable: false, searchable: false },
                { data: 'deleteaction', name: 'deleteaction', orderable: false, searchable: false }
            ]
        })
    );

    $('.dataTables_wrapper tbody').on( 'click', 'tr', function () {
        if ($(this).data().link != null) window.location = $(this).data().link;
    });

//---------------------------------
});
