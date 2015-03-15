@extends('app')

@section('content')
    <h1 class="page-heading">{{ $payment_processor->name }}</h1>

    @if (Auth::user())
        <script>
            window.csrfToken = '<?php echo csrf_token(); ?>';
        </script>
        <p>
            <a class="btn btn-primary btn-width" href="/payment_processors/{{ $payment_processor->id}}/edit/">
                <span class="fa fa-edit fa-1x space-right"></span><span class="button-font-size">Edit</span>
            </a>
            <a class="btn btn-primary btn-width" id="confirm" data-toggle="modal" href="#" data-target="#delPaymentProcessor" data-id="{{ $payment_processor->id }}">
                <span class="fa fa-trash fa-1x space-right"></span>
                <span class="button-font-size">Delete</span>
            </a>
        </p>

        <!-- Modal -->
        <div class="modal fade" id="delPaymentProcessor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">
                            <span class="fa fa-warning fa-3x"></span>
                            <span id="id"></span>
                            <span style="padding-left: 2em;">
                                ARE YOU SURE you want to delete {!! link_to($payment_processor->url, $payment_processor->name, ['target' => '_blank']) !!} ?
                            </span>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <p>If you delete this payment processor, it will be permanently removed from the system!</p>
                        <p>Any faucets that only has this payment processor will need a new one (or more).</p>
                    </div>
                    <div class="modal-footer">
                        <div id="delmodelcontainer" style="float:right">

                            <div id="yes" style="float:left; padding-right:10px">
                                {!! Form::open(array('action' => array('PaymentProcessorsController@destroy', $payment_processor->id), 'method' => 'DELETE')) !!}

                                {!! Form::submit('Yes', array('class' => 'btn btn-primary')) !!}

                                {!! Form::close() !!}
                            </div> <!-- end yes -->

                            <div id="no" style="float:left;">
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            </div><!-- end no -->

                        </div> <!-- end delmodelcontainer -->

                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    @endif

    <p>{!! link_to('faucets', '&laquo; Back to list of faucets') !!}</p>
    <p>{!! link_to('payment_processors', '&laquo; Back to list of payment processors') !!}</p>

    @if (Session::has('success_message'))
        <div class="alert alert-success">
            <span class="fa fa-thumbs-o-up fa-2x space-right"></span>
            {{ Session::get('success_message') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table bordered">
            <thead>
            <th>Payment Processor</th>
            <th>Associated Faucets</th>
            </thead>
            <tbody>
            <tr>
                <td>{!! link_to($payment_processor->url, $payment_processor->name, ['target' => 'blank']) !!}</td>
                <td>

                    <div class="accordion">
                        <h3>See Faucets</h3>
                        <div>
                            <ul class="faucet-payment-processors">
                                @foreach($payment_processor->faucets as $faucet)
                                    <li>{!! link_to_route('faucets.show', $faucet->name, array($faucet->id)) !!}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <script src="/js/accordion.js"></script>
@endsection