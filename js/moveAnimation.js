var zoomIn = function(elem) {
	$(elem).animate({"width": "+=150px", "height": "+=150px"}, 6000);
}

var animFrontPanel = function() {
	var hasClass = function(className, element) {
		return (" " + element.className + " ").indexOf(" " + className + " ") != -1;
	}

	var getStyleById = function(id) {
		return getComputedStyle( document.getElementById(id), null );
	}

	var front = document.getElementById("front");

	if (!hasClass("processing", front)) {
		front.classList.add("processing");

		var containerWidth = document.getElementById("front-container").offsetWidth;
		var frontWidth = front.offsetWidth;
		var paddingHoriz = containerWidth - (frontWidth*2);

		var xTarget, contentFadeIn, contentFadeOut;
		var infoFadeIn, infoFadeOut;

		if (getStyleById("login-content").display == "none") {
			xTarget = containerWidth - frontWidth - paddingHoriz;

			contentFadeOut = document.getElementById("register-content");
			contentFadeIn = document.getElementById("login-content");

			infoFadeIn = document.getElementById("login-info");
			infoFadeOut = document.getElementById("signup-info");
		} else {
			xTarget = 0;

			contentFadeOut = document.getElementById("login-content");
			contentFadeIn = document.getElementById("register-content");

			infoFadeIn = document.getElementById("signup-info");
			infoFadeOut = document.getElementById("login-info");
		}

		$(front).animate({"margin-left" : xTarget + "px"}, 600, function() {
			if (contentFadeIn.getAttribute("id") == "login-content") {
				front.style.marginLeft = "auto";
			}
			front.classList.remove("processing");
		});

		$(contentFadeOut).fadeToggle(300, function() {
			$(contentFadeIn).fadeToggle(300, function() {
				infoFadeIn.classList.add("hidden");
				infoFadeOut.classList.remove("hidden");
			});
		});

		if (getStyleById("signup-info").display == "none" || getStyleById("login-info").display == "none") {
			$(infoFadeIn).fadeToggle(300, function() {
				$(infoFadeOut).fadeToggle(300);
			});
		} else {
			infoFadeIn.removeAttribute("style");
			infoFadeOut.removeAttribute("style");

		}
		
	}
}

var inputFocus = function(input) {
	var inputTitle = input.previousElementSibling.getElementsByClassName("align-left");
	inputTitle = inputTitle[0];
	var inputIcon = input.previousElementSibling.getElementsByClassName("align-right");
	inputIcon = inputIcon[0];

	inputTitle.style.fontSize = "11px";
	inputTitle.style.fontFamily = "source sans pro bold";
	inputTitle.firstChild.nodeValue = inputTitle.firstChild.nodeValue.toUpperCase();

	var src = inputIcon.src;
	var pos = src.lastIndexOf(".");
	inputIcon.src = src.substr(0, pos) + "_active" + src.substr(pos, src.length-1);
}

var inputBlur = function(input) {
	var inputTitle = input.previousElementSibling.getElementsByClassName("align-left");
	inputTitle = inputTitle[0];
	var inputIcon = input.previousElementSibling.getElementsByClassName("align-right");
	inputIcon = inputIcon[0];

	inputTitle.style.fontSize = "15px";
	inputTitle.style.fontFamily = "source sans pro regular";
	var lowerText = inputTitle.innerHTML.toLowerCase();
	inputTitle.innerHTML = lowerText.substr(0, 1).toUpperCase() + lowerText.substr(1, lowerText.length-1);

	inputIcon.src = inputIcon.src.replace("_active", "");
}