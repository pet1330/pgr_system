<div class="table-responsive">
    <div class="box box-primary">
        <div class="box-body">
            <table class="table table-striped table-bordered" id="{{ $tableId }}" width="100%">
                <thead>
                    <tr class="dt_search">
                        {{ $slot }}
                    </tr>
                    <tr>
                        {{ $slot }}
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        {{ $slot }}
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>