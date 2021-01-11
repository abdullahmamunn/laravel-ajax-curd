<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>Laravel & Ajax CRUD Application!</title>
</head>
<body>
<header class="mt-5 mb-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1> Laravel & Ajax CRUD Application! </h1>
                <hr>
            </div>
        </div>
    </div>
</header>
<section class="body">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Alll Task</h3>
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#createContact">Create Task</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th> ID </th>
                                <th> Name </th>
                                <th> Email </th>
                                <th> Phone </th>
                                <th style="width:150px"> Action </th>
                            </tr>
                            </thead>
                            <tbody id="contactTable">


{{--                                <tr>--}}
{{--                                    <td></td>--}}
{{--                                    <td></td>--}}
{{--                                    <td></td>--}}
{{--                                    <td></td>--}}
{{--                                    <td style="width:150px">--}}
{{--                                        <a href="#" data-toggle="modal" data-target="#editModal" class="btn btn-sm btn-primary" id="edit">Edit</a>--}}
{{--                                        <a href="#" data-toggle="modal" data-target="#deleteTask"  class="btn btn-sm btn-danger delete">Delete</a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Create Modal -->
<div class="modal fade" id="createContact" tabindex="-1" role="dialog" aria-labelledby="createContact" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="contactForm">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <h5 class="modal-title" id="createTaskTitle">Create Task</h5>
                    <div id="successMsg"></div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="createTaskMessage"></div>
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter task name">
                        <span id="nameErrorMsg" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" class="form-control" id="email" placeholder="Enter task name">
                        <span id="emailErrorMsg" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Phone</label>
                        <input type="text" class="form-control" id="phone" placeholder="Enter task name">
                        <span id="phoneErrorMsg" class="text-danger"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-success" onclick="createContact()">Create Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="editContact">
                <div class="modal-header">
                    <h5 class="modal-title" id="editContact">Edit Contact</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="editTaskMessage"></div>
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" id="nameEdit" class="form-control"  placeholder="Enter task name">
                        <span id="nameErrorMsg" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" id="emailEdit" class="form-control"  placeholder="Enter task name">
                        <span id="emailErrorMsg" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Phone</label>
                        <input type="text" id="phoneEdit" class="form-control" placeholder="Enter task name">
                        <input type="hidden" id="id">
                        <span id="phoneErrorMsg" class="text-danger"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" onclick="updateContact()">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteTask" tabindex="-1" role="dialog" aria-labelledby="deleteTaskTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="deleteTaskForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteTaskTitle">Delete Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div id="deleteTaskMessage"></div>
                    <h4>Are you you want to delete this?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="{{asset('js/sweet-alert.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
</body>
</html>
