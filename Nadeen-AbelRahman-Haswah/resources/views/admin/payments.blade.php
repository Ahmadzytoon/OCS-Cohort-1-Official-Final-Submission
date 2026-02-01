@extends('admin.layout.master')

@section('title', 'Knowledge Items')

@section('content')
    <div class="page-inner">
        <div class="table-responsive">
            <table id="payments-table" class="display table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Company</th>
                        <th>Plan</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Paid At</th>
                        <th style="width: 15%">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    <!-- Example Row -->
                    <tr>
                        <td>Orange</td>

                        <td>
                            <span class="badge bg-primary">Business</span>
                        </td>

                        <td>
                            <strong>$199.00</strong>
                        </td>

                        <td>
                            <span class="badge bg-info">Credit Card</span>
                        </td>

                        <td>
                            <span class="badge bg-success">Paid</span>
                        </td>

                        <td>10/07/2024</td>

                        <td>
                            <div class="form-button-action">

                                <!-- View Invoice -->
                                <button type="button" class="btn btn-icon btn-success btn-round btn-sm"
                                    data-bs-toggle="tooltip" title="View Invoice">
                                    <i class="fa fa-file-invoice"></i>
                                </button>

                                <!-- Retry Payment -->
                                <button type="button" class="btn btn-icon btn-warning btn-round btn-sm"
                                    data-bs-toggle="tooltip" title="Retry Payment">
                                    <i class="fa fa-redo"></i>
                                </button>

                                <!-- Refund -->
                                <button type="button" class="btn btn-icon btn-danger btn-round btn-sm"
                                    data-bs-toggle="tooltip" title="Refund Payment">
                                    <i class="fa fa-undo"></i>
                                </button>

                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>
@endsection
