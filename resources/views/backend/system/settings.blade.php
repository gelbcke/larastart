@extends('layouts.app', [
'class' => 'sidebar-mini ',
'namePage' => __('system_settings.title'),
'activePage' => 'system_settings',
'activeNav' => '',
])

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card">
                <!-- form start -->
                <form method="POST" action="{{route('system_settings.update')}}" autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="currency_id" class="col-sm-2 col-form-label">{{__('system_settings.currency')}}</label>
                            <div class="col-sm-10">
                                <select class="custom-select" id="currency_id @error('currency_id') is-invalid @enderror" name="currency_id">
                                    @foreach($currencies as $currency)
                                    <option value="{{$currency->id}}" @if($settings[0]->currency_id == $currency->id) selected @endif>{{$currency->name}} - {{$currency->symbol}}</option>
                                    @endforeach
                                </select>
                                @error('currency_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="timezone_id" class="col-sm-2 col-form-label">{{__('system_settings.timezone')}}</label>
                            <div class="col-sm-10">
                                <select class="custom-select" id="timezone_id @error('timezone_id') is-invalid @enderror" name="timezone_id">
                                    @foreach($timezones as $timezone)
                                    <option value="{{$timezone->id}}" @if($settings[0]->timezone_id == $timezone->id) selected @endif>{{$timezone->name}} | {{$timezone->offset}}</option>
                                    @endforeach
                                </select>
                                @error('timezone_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="clock_format" class="col-sm-2 col-form-label">{{__('system_settings.clock_format')}}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('clock_format') is-invalid @enderror" id="clock_format" name="clock_format" value="{{$settings[0]->clock_format}}">
                                @error('clock_format')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <code>{{now()->format($settings[0]->clock_format)}}</code>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date_format" class="col-sm-2 col-form-label">{{__('system_settings.date_format')}}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('date_format') is-invalid @enderror" id="date_format" name="date_format" value="{{$settings[0]->date_format}}">
                                @error('date_format')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <code>{{now()->format($settings[0]->date_format)}}</code>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="datetime_format" class="col-sm-2 col-form-label">{{__('system_settings.datetime_format')}}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('datetime_format') is-invalid @enderror" id="datetime_format" name="datetime_format" value="{{$settings[0]->datetime_format}}">
                                @error('datetime_format')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <code>{{now()->format($settings[0]->datetime_format)}}</code>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-block">{{__('global.form.save')}}</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->




            @endsection