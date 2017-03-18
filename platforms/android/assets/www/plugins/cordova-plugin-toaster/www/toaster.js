cordova.define("cordova-plugin-toaster.notification", function(require, exports, module) {
var exec = require('cordova/exec');

module.exports = {

    showToast: function(param) {
    	return new Promise(function(resolve, reject) {
    		exec(function(result) {
    			resolve(result);
    		},
    		null,
    		"Toaster",
		param,
    		[]);
    	});   
    }

};
});
