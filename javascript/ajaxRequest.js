var ajaxRequest = new Class({
	initialize: function(used_method, request_type) {
		this.method = (used_method)? used_method : 'post';
		this.request_type = (request_type)? request_type : '';
	},
	setSuccessFn: function (fn) {
		this.sFn = fn;
	},
	setFailureFn: function (fn) {
		this.fFn = fn;
	},
	setExceptionFn: function (fn) {
		this.eFn = fn;
	},
	setRequestFn: function (fn) {
		this.rFn = fn;
	},
	send: function (send_url, query) {
		var request;
		
		var options = {url: send_url, method: this.method, onFailure: this.fFn, onException: this.eFn, onRequest: this.rFn};
		
		switch (this.request_type) {
			case 'html': request = new Request.HTML(options); break;
			case 'json': request = new Request.JSON(options); break;
			case 'jsonp': request = new Request.JSONP(options); break;
			default: request = new Request(options); break;
		}
		
		if (this.request_type=='jsonp') { request.setOptions({onComplete: this.sFn}); }
		else request.setOptions({onSuccess: this.sFn});
		
		if(query) request.send(query);
		else request.send();
	}
});