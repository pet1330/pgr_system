$(document).ready(function() {

    function initialise_column_search(o) {
        var that = o;
        var hd = o.header()
        var old_title=$(hd).html();
        $(hd).html('<input size="4" style="font-size: 8pt;" type="text" placeholder="filter"/><br>'+old_title);
        $('input', hd).click(
            function(e) {
               //do something
               e.stopPropagation();
            });
        $( 'input', o.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );

    }

    let generalSettings = {
        serverSide: true,
        processing: true,
        language: {
            "processing": '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
            },
        ajax: window.location.origin + window.location.pathname,
        info: true,
        // stateSave: true,
        bProcessing: true,
        deferRender: false,
        lengthMenu: [[10, 20, 30, 40, 50, 100, 200, 500, -1], [10, 20, 30, 40, 50, 100, 200, 500, "All"]],
        pageLength: 50,
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

    var as_table=$('#admin-student-table').DataTable(
        _.merge({}, generalSettings, {
            columns: [
                { data: 'first_name', name: 'student.first_name', searchable: true, orderable: true },
                { data: 'last_name', name: 'student.last_name', searchable: true, orderable: true },
                { data: 'university_id', name: 'student.university_id', searchable: true, orderable: true },
                { data: 'school', name: 'school.name', searchable: true, orderable: true },
                { data: 'tierFour', name: 'tierFour', searchable: true, orderable: true },
                { data: 'fundingType', name: 'fundingType.name', searchable: true, orderable: true },
                { data: 'programme', name: 'programme.name', searchable: true, orderable: true },
                { data: 'enrolmentStatus', name: 'enrolmentStatus.status', searchable: true, orderable: true },
                { data: 'studentStatus', name: 'studentStatus.status', searchable: true, orderable: true }

            ]
        })
    );

    // Apply the search
    as_table.columns().every( function () {
        initialise_column_search(this);
    } );


    // List of Admins for Admins
    //==============================================================================================
    var aa_table=$('#admin-admin-table').DataTable(
        _.merge({}, generalSettings, {
            columns: [
                { data: 'first_name', name: 'first_name', searchable: true, orderable: true },
                { data: 'last_name', name: 'last_name', searchable: true, orderable: true },
                { data: 'university_id', name: 'university_id', searchable: true, orderable: true }
            ]
        })
    );

    // Apply the search
    aa_table.columns().every( function () {
        initialise_column_search(this);
    } );

    // List of absence types for Admins
    //==============================================================================================
    $('#admin-absence-type-table').DataTable(
        _.merge({}, generalSettings, {
            columns: [
                { data: 'name', name: 'name', searchable: true, orderable: true },
                { data: 'interuption', name: 'interuption', searchable: false, orderable: true },
                { data: 'currentabsence_count', name: 'currentabsence_count', searchable: false, orderable: true },
                { data: 'absence_count', name: 'absence_count', searchable: false, orderable: true },
                { data: 'editaction', name: 'editaction', orderable: false, searchable: false },
                { data: 'deleteaction', name: 'deleteaction', orderable: false, searchable: false }
            ]
        })
    );

    // List of funding types for Admins
    //==============================================================================================
    $('#admin-funding-type-table').DataTable(
        _.merge({}, generalSettings, {
            columns: [
                { data: 'name', name: 'name', searchable: true, orderable: true },
                { data: 'students_count', name: 'students_count', searchable: false, orderable: true },
                { data: 'editaction', name: 'editaction', orderable: false, searchable: false },
                { data: 'deleteaction', name: 'deleteaction', orderable: false, searchable: false }
            ]
        })
    );

    // List of programmes for Admins
    //==============================================================================================
    $('#admin-programme-table').DataTable(
        _.merge({}, generalSettings, {
            columns: [
                { data: 'name', name: 'name', searchable: true, orderable: true},
                { data: 'duration', name: 'duration', searchable: true, orderable: true},
                { data: 'students_count', name: 'students_count', searchable: false, orderable: true},
                { data: 'editaction', name: 'editaction', orderable: false, searchable: false},
                { data: 'deleteaction', name: 'deleteaction', orderable: false, searchable: false}
            ]
        })
    );

    // List of student statuses for Admins
    //==============================================================================================
    $('#admin-student-status-table').DataTable(
        _.merge({}, generalSettings, {
            columns: [
                { data: 'status', name: 'status', searchable: true, orderable: true},
                { data: 'students_count', name: 'students_count', searchable: false, orderable: true},
                { data: 'editaction', name: 'editaction', orderable: false, searchable: false},
                { data: 'deleteaction', name: 'deleteaction', orderable: false, searchable: false}
            ]
        })
    );

    // List of enrolment statuses for Admins
    //==============================================================================================
    $('#admin-enrolment-status-table').DataTable(
        _.merge({}, generalSettings, {
            columns: [
                { data: 'status', name: 'status', searchable: true, orderable: true},
                { data: 'students_count', name: 'students_count', searchable: false, orderable: true},
                { data: 'editaction', name: 'editaction', orderable: false, searchable: false},
                { data: 'deleteaction', name: 'deleteaction', orderable: false, searchable: false}
            ]
        })
    );

    // List of milestone types for Admins
    //==============================================================================================
    $('#admin-milestone-type-table').DataTable(
        _.merge({}, generalSettings, {
            columns: [
                { data: 'name', name: 'name', searchable: true, orderable: true },
                { data: 'duration', name: 'duration', searchable: true, orderable: true },
                { data: 'student_makable', name: 'student_makable', searchable: true, orderable: true },
                { data: 'milestones_count', name: 'milestones_count', searchable: false, orderable: true },
                { data: 'milestone_templates_count', name: 'milestone_templates_count', searchable: false, orderable: true },
                { data: 'editaction', name: 'editaction', orderable: false, searchable: false },
                { data: 'deleteaction', name: 'deleteaction', orderable: false, searchable: false }
            ]
        })
    );

    // List of timeline templates for Admins
    //==============================================================================================
    $('#admin-timeline-template-table').DataTable(
        _.merge({}, generalSettings, {
            columns: [
                { data: 'name', name: 'name', searchable: true, orderable: true },
                { data: 'milestone_templates_count', name: 'milestone_templates_count', searchable: false, orderable: true },
                { data: 'editaction', name: 'editaction', orderable: false, searchable: false },
                { data: 'deleteaction', name: 'deleteaction', orderable: false, searchable: false }
            ]
        })
    );

    // List of milestones for Admins
    //==============================================================================================
    $('#admin-milestones-table').DataTable(
        _.merge({}, generalSettings, {
            columns: [
                { data: 'name', name: 'type.name', searchable: true, orderable: true },
                { data: 'due_date', name: 'due_date', searchable: true, orderable: true },
                { data: 'school', name: 'student.school.name', searchable: true, orderable: true },
                { data: 'first_name', name: 'student.student.first_name', searchable: true, orderable: true },
                { data: 'last_name', name: 'student.student.last_name', searchable: true, orderable: true },
            ]
        })
    );

    // List of submitted milestones for Admins
    //==============================================================================================
    $('#admin-submitted-milestones-table').DataTable(
        _.merge({}, generalSettings, {
            columns: [
                { data: 'name', name: 'name', searchable: true, orderable: true },
                { data: 'due_date', name: 'due_date', searchable: true, orderable: true },
                { data: 'submitted_date', name: 'submitted_date', searchable: true, orderable: true },
                { data: 'school', name: 'student.school.name', searchable: true, orderable: true },
                { data: 'first_name', name: 'student.student.first_name', searchable: true, orderable: true },
                { data: 'last_name', name: 'student.student.last_name', searchable: true, orderable: true },
            ]
        })
    );

    // List of milestone templates for Admins
    //==============================================================================================
    $('#admin-milestone-template-table').DataTable(
        _.merge({}, generalSettings, {
            columns: [
                { data: 'name', name: 'type.name', searchable: true, orderable: true },
                { data: 'due', name: 'due', searchable: false, orderable: true },
                { data: 'editaction', name: 'editaction', orderable: false, searchable: false },
                { data: 'deleteaction', name: 'deleteaction', orderable: false, searchable: false }
            ]
        })
    );

    // List of colleges for Admins
    //==============================================================================================
    $('#admin-college-table').DataTable(
        _.merge({}, generalSettings, {
            columns: [
                { data: 'name', name: 'name', searchable: true, orderable: true },
                { data: 'schools_count', name: 'schools_count', searchable: false, orderable: true },
                { data: 'editaction', name: 'editaction', orderable: false, searchable: false },
                { data: 'deleteaction', name: 'deleteaction', orderable: false, searchable: false }
            ]
        })
    );

    // List of school for Admins
    //==============================================================================================
    $('#admin-school-table').DataTable(
        _.merge({}, generalSettings, {
            columns: [
                { data: 'name', name: 'name', searchable: true, orderable: true },
                { data: 'college', name: 'college.name', searchable: true, orderable: true },
                { data: 'students_count', name: 'students_count', searchable: false, orderable: true },
                { data: 'editaction', name: 'editaction', orderable: false, searchable: false },
                { data: 'deleteaction', name: 'deleteaction', orderable: false, searchable: false }
            ]
        })
    );

    // List of Staff for Admins
    //==============================================================================================
    $('#admin-staff-table').DataTable(
        _.merge({}, generalSettings, {
            columns: [
                { data: 'first_name', name: 'first_name', searchable: true, orderable: true },
                { data: 'last_name', name: 'last_name', searchable: true, orderable: true },
                { data: 'university_id', name: 'university_id', searchable: true, orderable: true }
            ]
        })
    );

    // List of Staff to upgrade for Admins
    //==============================================================================================
    $('#admin-staff-upgrade-table').DataTable(
        _.merge({}, generalSettings, {
            columns: [
                { data: 'first_name', name: 'first_name', searchable: true, orderable: true },
                { data: 'last_name', name: 'last_name', searchable: true, orderable: true },
                { data: 'university_id', name: 'university_id', searchable: true, orderable: true },
                { data: 'upgrade', name: 'upgrade', searchable: false, orderable: false }
            ],
            "language": {
                "emptyTable": 'No Staff members are eligable for an Admin upgrade.<br>'+
                               'Staff members who supervise students cannot be made into admin.<br>'
            }
        })
    );

    // List of Admins to downgrade
    //==============================================================================================
    $('#admin-staff-downgrade-table').DataTable(
        _.merge({}, generalSettings, {
            columns: [
                { data: 'first_name', name: 'first_name', searchable: true, orderable: true },
                { data: 'last_name', name: 'last_name', searchable: true, orderable: true },
                { data: 'university_id', name: 'university_id', searchable: true, orderable: true },
                { data: 'downgrade', name: 'downgrade', searchable: false, orderable: false }
            ]
        })
    );

    // List of permissions for each role
    //==============================================================================================
    $('#admin-role-permissions-table').DataTable(
        _.merge({}, generalSettings, {
            columns: [
                { data: 'name', name: 'name', searchable: true, orderable: true },
                { data: 'abilities', name: 'abilities', searchable: true, orderable: true },
                { data: 'editaction', name: 'editaction', orderable: false, searchable: false },
            ]
        })
    );

    // List of roles fore each user
    //==============================================================================================
    $('#admin-user-roles-table').DataTable(
        _.merge({}, generalSettings, {
            columns: [
                { data: 'first_name', name: 'first_name', searchable: true, orderable: true },
                { data: 'last_name', name: 'last_name', searchable: true, orderable: true },
                { data: 'university_id', name: 'university_id', searchable: true, orderable: true },
                { data: 'user_type', name: 'user_type', searchable: true, orderable: true },
                { data: 'college', name: 'college.name', searchable: true, orderable: true },
                { data: 'students_count', name: 'students_count', searchable: false, orderable: true },
                { data: 'editaction', name: 'editaction', orderable: false, searchable: false },
                { data: 'deleteaction', name: 'deleteaction', orderable: false, searchable: false }
            ]
        })
    );

    // List of absences for student dashboard
    //==============================================================================================
    $('#student-absences-table').DataTable(
        _.merge({}, generalSettings, {
            "searching": false,
            dom: 'rt',
            columns: [
                { data: 'from', name: 'from', searchable: false, orderable: true },
                { data: 'to', name: 'to', searchable: false, orderable: true },
                { data: 'duration', name: 'duration', searchable: false, orderable: true },
                { data: 'type', name: 'type.name', searchable: false, orderable: true }
            ]
        })
    );

    // List of absences for student dashboard for admin
    //==============================================================================================
    $('#admin-absences-table').DataTable(
        _.merge({}, generalSettings, {
            "searching": false,
            dom: 'rt',
            columns: [
                { data: 'from', name: 'from', searchable: false, orderable: true },
                { data: 'to', name: 'to', searchable: false, orderable: true },
                { data: 'duration', name: 'duration', searchable: false, orderable: true },
                { data: 'type', name: 'type.name', searchable: false, orderable: true },
                { data: 'deleteaction', name: 'deleteaction', orderable: false, searchable: false }
            ]
        })
    );

    $('.dataTables_wrapper tbody').on( 'click', 'tr', function () {
        if ($(this).data().link != null) window.location = $(this).data().link;
    });
});
