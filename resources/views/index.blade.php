<html>
    <head>
        <title>{{ trans('base.app') }}</title>
        <link rel="stylesheet" type="text/css" href="{{ url('assets/semantic.min.css') }}">
        <script src="{{ url('assets/jquery.min.js') }}"></script>
        <script src="{{ url('assets/semantic.min.js') }}"></script>
    </head>
    <body>
        <div class="ui grid container centered" style="padding-top: 20vh; min-height: 100vh;">
            <div class="four wide column"></div>
            <div class="eight wide column center aligned">
                <h1 style="font-size: 96px;">{{ trans('base.app') }}</h1>
                <p>{{ trans('base.description') }}</p>
                @if (count($errors) > 0)
                    <div class="ui error message">
                        <i class="close icon"></i>
                        <div class="header">{!! trans('base.whoops') !!}</div>
                        <ul class="list">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (null !== session('key'))
                    <div class="ui positive message">
                        <i class="close icon"></i>
                        {!! trans('base.created_record', ['key' => session('key')]) !!}
                    </div>
                 @endif
                 @if (null !== session('delete'))
                     <div class="ui positive message">
                         <i class="close icon"></i>
                         {!! trans('base.deleted_record') !!}
                     </div>
                 @endif
                 @if (null !== session('error'))
                     <div class="ui error message">
                         <i class="close icon"></i>
                         {{ session('error') }}
                     </div>
                 @endif
                <div class="ui segment" id="generate" style="padding-bottom: 0;" hidden>
                    <form class="ui form" action="/generate" method="post">
                        <div class="field">
                            <div class="ui right labeled input">
                                <div class="ui label"><i class="icon browser"></i></div>
                                <input type="text" name="fqdn" placeholder="Choose Prefix">
                                <select class="ui dropdown label compact selection" name="domain">
                                    @foreach($domains as $domain)
                                        <option value="{{ $domain }}">.{{ $domain }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui left labeled input">
                                <div class="ui left label"><i class="icon send"></i></div>
                                <input type="text" name="ip" placeholder="Enter IP">
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button class="fluid ui blue button" type="submit">{{ trans('base.submit') }}</button>
                    </form>
                </div>
                <div class="ui segment" id="destroy" style="padding-bottom: 0;" hidden>
                    <form class="ui form" action="/destroy" method="post">
                        <div class="field">
                            <div class="ui left labeled input">
                                <div class="ui left label"><i class="icon key"></i></div>
                                <input type="text" name="token" placeholder="Record Token">
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button class="fluid ui blue button" type="submit">{{ trans('base.submit') }}</button>
                    </form>
                </div>
                <div class="ui buttons">
                    <button class="ui green button" id="generateBtn"><i class="plus icon"></i> {{ trans('base.generate') }}</button>
                    <div class="or"></div>
                    <button class="ui red button" id="destroyBtn"><i class="remove icon"></i>{{ trans('base.destroy') }}</button>
                </div>
                <div class="ui divider"></div>
                <div class="ui horizontal bulleted link list">
                    <a class="item" href="{!! trans('base.urls.home') !!}">{{ trans('base.home') }}</a>
                    <a class="item" id="legal">{{ trans('base.legal.label') }}</a>
                    <a class="item" href="{!! trans('base.urls.help') !!}">{{ env('SUPPORT_EMAIL', '@') }}</a>
                </div>
            </div>
            <div class="four wide column"></div>
        </div>
    </body>
    <div class="ui modal">
        <div class="header">{{ trans('base.legal.label') }}</div>
        <div class="content">
            <p>{!! trans('base.legal.content') !!}</p>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#generateBtn').click(function() {
                $('#generate').transition('scale');
                $('#destroy').transition({'animation': 'scale out down', 'duration': 0});
            });
            $('#destroyBtn').click(function() {
                $('#destroy').transition('scale');
                $('#generate').transition({'animation': 'scale out down', 'duration': 0});
            });
            $('.ui.dropdown').dropdown();
            $('#legal').click(function() {
                $('.ui.modal').modal('show');
            });
        });
    </script>
</html>
