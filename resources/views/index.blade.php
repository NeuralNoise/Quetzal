<html>
	<head>
		<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex">
        <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ url('css/quetzal.min.css') }}">
        <link rel="stylesheet" href="{{ url('css/animate.css') }}">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/socket.io/1.3.7/socket.io.min.js"></script>
	</head>
	<body>
		<div class="container col-md-6 col-md-offset-3 text-center" style="padding-top: 20vh; min-height: 100vh;">
			<h1 style="font-size: 120px;">{{ trans('base.quetzal') }}</h1>
			<p>{{ trans('base.description') }}</p>
			<div class="well animated fadeInDown hide" style="padding-top: 0; padding-bottom: 0;" id="generate">
				<form action="/generate" method="post">
					<h3>{{ trans('base.generate') }}</h3><hr>
					<div class="form-group">
						<div class="input-group">
	  						<span class="input-group-addon"><i class="fa fa-globe"></i></span>
	  						<input type="text" class="form-control" name="fqdn" id="fqdn" placeholder="Choose Prefix - e.x. mynode">
							<span class="input-group-addon">.dactyl.link</span>
						</div>
					</div>
					<div class="form-group">
						<label for="ip" class="text-left"></label>
						<div class="input-group">
	  						<span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
	  						<input type="text" class="form-control" name="ip" id="ip" placeholder="Node IP - e.x. 172.16.254.1">
						</div>
					</div>
					<button type="submit" class="btn btn-block btn-primary">{{ trans('base.submit') }}</button>
				</form>
			</div>
			<div class="well animated fadeInDown hide" style="padding-top: 0; padding-bottom: 0;" id="delete">
				<form action="/destroy" method="post">
					<h3>{{ trans('base.destroy') }}</h3><hr>
					<div class="form-group">
						<div class="input-group">
	  						<span class="input-group-addon"><i class="fa fa-key"></i></span>
	  						<input type="text" class="form-control" name="fqdn" id="fqdn" placeholder="Enter Token">
						</div>
					</div>
					<button type="submit" class="btn btn-block btn-primary">{{ trans('base.submit') }}</button>
				</form>
			</div>
			<div class="btn-group">
				<button type="button" class="btn btn-success" id="generateBtn"><i class="fa fa-plus"></i> {{ trans('base.generate') }}</button>
  				<button type="button" class="btn btn-danger" id="deleteBtn"><i class="fa fa-trash"></i> {{ trans('base.destroy') }}</button>
			</div>
			<hr><p><a href="#" data-toggle="modal" data-target="#legal">{{ trans('base.tos.string') }}</a> | <a href="#">{{ trans('base.help') }}</a> | <a href="#">{{ trans('base.pterodactyl_home') }}</a></p>
		</div>
		<div class="modal fade" id="legal" aria-labelledby="legalLabel">
		    <div class="modal-dialog" role="document">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		                <h4 class="modal-title" id="legalLabel">{{ trans('base.tos.string') }}</h4>
		            </div>
		            <div class="modal-body">
		                {{ trans('base.tos.content') }}
		            </div>
		        </div>
		    </div>
		</div>
	</body>
	<script type="text/javascript">
	$(document).ready(function() {
		$('#generateBtn').click(function() {
			$('#delete').addClass('hide')
			$('#generate').removeClass('hide')
		});
		$('#deleteBtn').click(function() {
			$('#generate').addClass('hide')
			$('#delete').removeClass('hide')
		});
	});
	</script>
</html>