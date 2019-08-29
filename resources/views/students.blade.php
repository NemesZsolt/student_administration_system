@extends('layouts.app')

@section('content')

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active students-selector-box" id="home-tab" data-toggle="tab" href="#home" role="tab"
               aria-controls="home"
               aria-selected="true">
                <p>Students</p>
                <p class="sas-gray">{{$students->total()}} Students registered</p>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
               aria-selected="false">
                <p>Study Groups</p>
                <p>{{count($studyGroups)}} study groups with {{$enrolledStudentsNumber}} students</p>
            </a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="top-navigation-panel">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="title-top sas-gray">Search for name</label>

                            <div class="input-icons">
                                <i class="fa fa-search icon"></i>
                                <input type="text" name="search" id="search" class="input-field form-control"
                                       type="text">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="bottom-container">
                            <div class="float-left">
                                <i class="fa fa-user icon"></i>
                                {{$students->total()}} students
                                <button type="button" class="btn btn-new"
                                        onclick="location.href='{{route('students.create')}}'"><i
                                            class="fa fa-edit"></i>New
                                </button>

                                <button type="button" class="btn btn-new"
                                        onclick="location.href='{{route('enrollment.index')}}'"><i
                                            class="fa fa-edit"></i>Enroll
                                </button>
                            </div>
                            <div class="float-right">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row student-bottom-container">
                <div class="col-md-3">
                    <p class="title-top">Filters for study groups</p>
                    @foreach($students as $student)
                        @if(count($student->enrolled) > 0)
                            @foreach($student->enrolled as $enrolledStudent)
                                <label class="filter-container">
                                    <span class="filter-label sas-gray">{{mb_strimwidth($enrolledStudent->group->name, 0, 25, "...")}}</span>
                                    <input type="checkbox" name="cat[]" value="{{$enrolledStudent->student_id}}"
                                           id="Check{{$enrolledStudent->group->id}}">
                                    <span class="checkmark"></span>
                                </label>
                            @endforeach
                        @endif
                    @endforeach
                </div>
                <div class="col-md-9">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="sas-gray">
                                <tr>
                                    <th width="20%" class="sorting" data-sorting_type="asc" data-column_name="id"
                                        style="cursor: pointer">
                                        Name <span id="id_icon"></span>
                                    </th>
                                    <th width="5%" class="sorting" data-sorting_type="asc" data-column_name="post_title"
                                        style="cursor: pointer">Sex <span id="post_title_icon"></span></th>
                                    <th width="50%">Place and date of birth</th>
                                    <th width="25%">Groups</th>
                                </tr>
                                </thead>
                                <tbody>
                                @include('pagination_data')
                                </tbody>
                            </table>
                            <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
                            <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id"/>
                            <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="form-group">
                <ul class="list-group">
                    @foreach($studyGroups as $group)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{$group->name}}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {

            function clear_icon() {
                $('#id_icon').html('');
                $('#post_title_icon').html('');
            }

            function fetch_data(page, sort_type, sort_by, query) {
                $.ajax({
                    url: "/pagination/fetch_data?page=" + page + "&sortby=" + sort_by + "&sorttype=" + sort_type + "&query=" + query,
                    success: function (data) {

                        $('tbody').html('');
                        $('tbody').html(data);
                    }
                })
            }

            $(document).on('change', 'input[name="cat[]"]', function () {

                var categories = [];

                $('input[name="cat[]"]:checked').each(function () {
                    categories.push($(this).val());
                });

                var column_name = $('#hidden_column_name').val();
                var sort_type = $('#hidden_sort_type').val();
                var page = $('#hidden_page').val();

                fetch_data(page, sort_type, column_name, categories);
            });

            $(document).on('keyup', '#search', function () {

                var query = $('#search').val();
                var column_name = $('#hidden_column_name').val();
                var sort_type = $('#hidden_sort_type').val();
                var page = $('#hidden_page').val();
                fetch_data(page, sort_type, column_name, query, '');
            });

            $(document).on('click', '.sorting', function () {
                var column_name = $(this).data('column_name');
                var order_type = $(this).data('sorting_type');
                var reverse_order = '';
                if (order_type == 'asc') {
                    $(this).data('sorting_type', 'desc');
                    reverse_order = 'desc';
                    clear_icon();
                    $('#' + column_name + '_icon').html('<i class="fa fa-caret-down"></i>');
                }
                if (order_type == 'desc') {
                    $(this).data('sorting_type', 'asc');
                    reverse_order = 'asc';
                    clear_icon();
                    $('#' + column_name + '_icon').html('<i class="fa fa-caret-up"></i>');
                }
                $('#hidden_column_name').val(column_name);
                $('#hidden_sort_type').val(reverse_order);
                var page = $('#hidden_page').val();
                var query = $('#search').val();
                fetch_data(page, reverse_order, column_name, query);
            });

            $(document).on('click', '.pagination a', function (event) {

                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];

                $('#hidden_page').val(page);
                var column_name = $('#hidden_column_name').val();
                var sort_type = $('#hidden_sort_type').val();

                var query = $('#search').val();

                $('li').removeClass('active');
                $(this).parent().addClass('active');
                fetch_data(page, sort_type, column_name, query);
            });

        });
    </script>
@endpush