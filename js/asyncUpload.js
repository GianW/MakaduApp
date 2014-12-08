Element.extend({
	"upload": function(options) {
		if(this.getTag() != "form") return false
		var iFrame = new Element("iframe", {
			"id": "fileUpload",
			"name": "fileUpload",
			"styles": { "display": "none" }
		})
		this.adopt(iFrame)
		window.frames["fileUpload"].name = "fileUpload"
		iFrame.addEvent("load", function() {
			iFrame.removeEvent("load", arguments.callee)
			if($type(options.onComplete) == "function") {
				options.onComplete(iFrame.contentWindow.document.body.innerHTML)
			}
			iFrame.remove.delay(20, iFrame)
		})
		this.setProperties({
			"target": "fileUpload",
			"enctype": "multipart/form-data",
			"encoding": "multipart/form-data",
			"method": "post"
		})
		return this
	}
})