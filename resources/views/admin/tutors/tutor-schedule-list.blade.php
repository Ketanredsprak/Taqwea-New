    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tutor Schedule</h5>
                <a href="javascript:void(0)" class="close " data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            </div>
            <div class="modal-body modal-body-md">
                <div class="common-table card rounded-0">
                    <div class="table-responsive">
                        <table class="table table-tranx">
                            <thead>
                                <tr>
                                    <th class="w_70 nosort">S.No.</th>
                                    <th>Class/Webinar Name</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Duration</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($classes as $class)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{ucfirst($class->class_name)}}</td>
                                    <td>{{convertDateToTz($class->start_time, 'UTC', 'h:i A')}}</td>
                                    <td>{{convertDateToTz($class->end_time, 'UTC', 'h:i A')}}</td>
                                    <td>{!! getDuration($class->duration) !!}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
