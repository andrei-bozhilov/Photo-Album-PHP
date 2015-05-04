function addPictureToAlbum(event) {
	var picName = document.getElementById('picture-name').value;

	var openedAlbum = document.getElementById('opened-album-title');
	var albumId = openedAlbum.getAttribute('class');

	try {
		var validPicName = validateString(picName, 'Picture name');
		var picFile = Actions.uploadPicture(validPicName);

		Queries.getObjectById('Album', albumId).then(function(album) {
			Actions.addPictureToAlbum(validPicName, picFile, album).then(function() {
				Queries.getLastSaveObject('Picture', function(pic) {
					console.log(pic[0]);
					createPictureItem(pic[0]);
				});
			});
			closePopup();
		});
	} catch (error) {
		// maybe log the error..
	}
}

function addCommentToAlbum(event) {
	var commentContent = document.getElementById("textareaAlbumComment").value;
	var commentOf = document.getElementById("name-for-album-comment").value.trim();

	var openedAlbum = document.getElementById('opened-album-title');
	var albumId = openedAlbum.getAttribute('class');

	try {
		var validName = validateString(commentOf, 'Name');

		Queries.getObjectById("Album", albumId).then(function(album) {
			Actions.addCommentToAlbum(validName, commentContent, album);
		}).then(function(result) {
			emptyFields();
			alert('The comment was successfully added."');
		});
	} catch (error) {
		alert(error.message);
	}
}

function createAlbum(event) {
	var albumName = document.getElementById("album-name").value.trim(),
	    a = document.getElementById("album-category"),
	    categoryId = a.options[a.selectedIndex].value,
	    regexValidate = new RegExp("(^[A-Za-z0-9]+[A-Za-z0-9 ][A-Za-z0-9 ]*$)");
	document.getElementById("album-name").value = albumName;
	console.log(albumName);
	if (!albumName || albumName.length > 25 || !regexValidate.test(albumName)) {
		alert("Album name should be between 0 and 25 symbols and should contain only latin letters, numbers, intervals and dashes.");
	} else {
		Queries.getObjectById("Category", categoryId).then(function(category) {
			Actions.createAlbum(albumName, category);
		}).then(function(result) {
			Noty.success("Album created");
			Queries.getLastSaveObject("Album", function(x) {
				Dom.listAlbums(x);
				openAlbum();
				emptyFields();
				Dom.openAnAlbum.call($('#' + x[0].objectId)[0]);

			});
			closePopup();
		});
	}
}

function rateAlbum() {
	var albumId = $('#albumId').attr('data-album');
	var rating = document.getElementById("rate-album-range").value;
	console.log(albumId);
	console.log(rating);
	$.ajax({
		url : "/user/rate_album/" + albumId + "/" + rating,
		method : "GET"
	}).success(function(data) {
		console.log(rating);
		$('body').hide().html(data).fadeIn(1500);
	}).error(function(data) {
		console.log(data);
	});
}

function ratePicture(event) {
	var pictureId = $('#popup-rate-picture form').attr('id');
	var rating = document.getElementById("rate-picture-range").value;

	Actions.ratePicture(pictureId, parseInt(rating), function success() {
		/*Noty.success('The picture was successfully rated with ' + rating + ' !');
		 var picture = $('#album-images-container').children().filter(function () {
		 return $(this).('id') == pictureId;
		 });

		 var changeElement = $('#' + pictureId)[0];

		 Dom.changeRating(picture, changeElement, rating, "Rating: ");
		 closePopup();*/
	}, function error(error) {
		Noty.error("Sorry, there was a problem");
	});
}

function addCommentToPicture(event) {

	var authorInput = document.getElementById("name-for-pic-comment"),
	    commentInput = document.getElementById("comment-value"),
	    author = authorInput.value,
	    comment = commentInput.value,
	    pic;

	openedImageId = $("#pic-shown").attr("data-id");

	Queries.getObjectById("Picture", openedImageId).then(function(picture) {
		pic = picture;
		Actions.addCommentToPicture(author, comment, picture);
	}).then(function(result) {
		Queries.getCommentsByPicture(pic).then(function(comments) {
			Dom.loadPictureComments(comments);
			authorInput.value = "";
			commentInput.value = "";
		});
	});
}

function loadHomePage() {
	collapseAlbum();
	document.getElementById("back-button").classList.toggle("back-button-change");

	changeSelectHTMLTagToDefaultState('#filters-category', 'all');
	changeSelectHTMLTagToDefaultState('#filters-rating-picture', 'Rating (ascending)');
	changeSelectHTMLTagToDefaultState('#filters-rating', 'Rating (ascending)');
}

function changeSelectHTMLTagToDefaultOption(elementID, defaultOptionValue) {
	$(elementID).val(defaultOptionValue)// change displaying option
	$(elementID).trigger('change');
	// trigger event
}

function createCategory() {
	var catName = document.getElementById('category-name').value;
	// Get from input field
	Actions.createCategory(catName).then(function(result) {
		console.log("Category created.");
	});
	Dom.clearCategories();
	Dom.listCategotes();
	closePopup();
	Noty.success("Category created");
}

function getSelectedTextFromSelect(elementId) {
	var elt = document.getElementById(elementId);

	if (elt.selectedIndex === -1)
		return null;

	return elt.options[elt.selectedIndex].text;
}

function validateString(value, varName) {
	var trimmed = value.trim();
	var regexValidate = new RegExp("(^[A-Za-z0-9]+[A-Za-z0-9 ][A-Za-z0-9 ]*$)");

	if (!trimmed || trimmed.length > 25 || !regexValidate.test(trimmed)) {
		throw new Error(varName + " should be between 0 and 25 symbols and should contain only latin letters, numbers, intervals and dashes.");
	} else {
		return trimmed;
	}
}

// FRONT END SCRIPTS
function openAlbum() {
	document.getElementById("back-button").classList.toggle("back-button-change");
	document.getElementById("back-button").style.display = "block";
	document.getElementById("album-opened-container").style.display = "block";
	document.getElementById("main-container").classList.add("main-collapse");
	document.getElementById("add-album-button").style.display = "none";
	document.getElementById("add-picture-button").style.display = "block";
	document.getElementById("rate-album").style.display = "block";
	document.getElementById("add-category-button").style.display = "none";
}

function collapseAlbum() {
	document.getElementById("back-button").classList.toggle("back-button-change");
	document.getElementById("back-button").style.display = "none";
	document.getElementById("main-container").classList.remove("main-collapse");
	document.getElementById("album-opened-container").style.display = "none";
	document.getElementById("add-album-button").style.display = "block";
	document.getElementById("add-picture-button").style.display = "none";
	document.getElementById("rate-album").style.display = "none";
	document.getElementById("add-category-button").style.display = "block";
	$('#album-opened-container ul').remove();
	$('#album-opened-container h2').remove();
	$('#popup-album-comment-container').remove();
	$('#filters-rating-picture').hide();
	$('#filters-rating-picture').val("Rating (ascending)");
	$('#filters-rating').show();
	$('#filters-category').show();
	$('#bc').html("<span>Filters: </span>");
}

function loadPopup(that) {
	$("#pic-comments-list").html("");
	document.getElementById("popup-picture").style.display = "block";
	Dom.loadPicturePopup(that);
	setSize();
}

function emptyFields() {
	if (document.getElementById("name-for-album-comment")) {
		document.getElementById("name-for-album-comment").value = '';
	}

	if (document.getElementById("textareaAlbumComment")) {
		document.getElementById("textareaAlbumComment").value = '';
	}

	showVal(1, 'rate-picture-value');
	showVal(1, 'rate-album-value');
	document.getElementById('rate-album-range').value = 1;
	document.getElementById('rate-picture-range').value = 1;
	document.getElementById("album-name").value = "";
	document.getElementById("picture-name").value = "";
	document.getElementById("image-file").value = "";
	document.getElementById("category-name").value = "";
}

function closePopup() {
	document.getElementById("popup-picture").style.display = "none";
	document.getElementById("popup-add-album").style.display = "none";
	document.getElementById("popup-add-category").style.display = "none";
	document.getElementById("popup-add-picture").style.display = "none";
	document.getElementById("popup-rate-album").style.display = "none";
	document.getElementById("popup-rate-picture").style.display = "none";
	emptyFields();
}

function setSize() {
	var viewportWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
	var viewportHeight = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);

	var img = document.getElementById("pic-shown");
	var pictureWidth = (img.clientWidth);
	var pictureHeight = (img.clientHeight);

	var widthContainer = viewportWidth - 200;
	var heightContainer = viewportHeight - 100;
	document.getElementById("popup-picture-container").style.width = widthContainer.toString() + 'px';
	document.getElementById("popup-picture-container").style.height = heightContainer.toString() + 'px';

	var aspectRatio = (pictureWidth) / (pictureHeight);

	document.getElementById("pic-all-comments").style.height = (heightContainer - 260).toString() + 'px';
	document.getElementById("popup-picture-image-container").style.width = (widthContainer - 380).toString() + 'px';
	document.getElementById("popup-picture-image-container").style.height = heightContainer.toString() + 'px';
	//if horizontal
	if ((widthContainer - 380) / heightContainer > aspectRatio) {
		document.getElementById("pic-shown").style.maxHeight = '100%';
		document.getElementById("pic-shown").style.maxWidth = 'auto';
	} else {
		document.getElementById("pic-shown").style.maxWidth = '100%';
		document.getElementById("pic-shown").style.maxHeight = 'auto';
	}
}

function loadAddAlbum() {
	document.getElementById("popup-add-album").style.display = "block";
}

function loadAddCategory() {
	document.getElementById("popup-add-category").style.display = "block";
}

function loadAddPicture() {
	document.getElementById("popup-add-picture").style.display = "block";
}

function loadRateAlbum() {
	document.getElementById("popup-rate-album").style.display = "block";
}

function loadRatePicture() {
	document.getElementById("popup-rate-picture").style.display = "block";
	$('#popup-rate-picture form').attr('id', this.id);
}

function showVal(newVal, id) {
	id = id.toString().replace('range', 'value');
	document.getElementById(id).innerHTML = "Rate: " + newVal;

	var parentId = id.split('-')[1];

	var divs = $('#' + 'popup-rate-' + parentId + ' .rate-scale')
	$(divs[0]).css('height', '100px');
	$(divs[0]).css('background-color', "rgba(0,0,0,0)");

	for (var i = newVal - 1; i < divs.length; i++) {
		$(divs[i]).css('height', '100px');
		$(divs[i]).css('background-color', "rgba(0,0,0,0)");

	}

	for (var i = 1; i < newVal; i++) {
		$(divs[parseInt(i)]).css('background-color', "rgba(0,0,0," + i / 10 + ")");
		$(divs[parseInt(i)]).css('height', i * 10 + "px");
	}
}


$(document).ready(function() {
	$(window).scroll(function(event) {
		var scroll = $(window).scrollTop();
		if (scroll > 0) {
			document.getElementById("main-header").style.height = "50px";
			document.getElementById("main-header").style.paddingTop = "0px";
			document.getElementById("pusher").style.marginTop = "100px";

		}
		if (scroll == 0) {
			document.getElementById("main-header").style.height = "80px";
			document.getElementById("main-header").style.paddingTop = "15px";
			document.getElementById("pusher").style.marginTop = "80px";
		}
	});
	$(document).on("click", ".pic-hover", function() {
		loadPopup($(this));
	});
	$(document).on("click", ".slider-element", function() {
		openAlbum();
		Dom.openAnAlbum.call(this);
	});
});

function performSearch() {
	var keyword = $("#search-bar").val(),
	    albumList = $('#album-list').children(),
	    albumName;

	albumList.show();
	albumList.each(function(number, element) {
		albumName = $(element).children('h3.album-title').html().toLowerCase();
		if (albumName.indexOf(keyword) === -1) {
			$(element).hide();
		}
	});
}

function attachEventes() {
	document.getElementById("add-album-submit").addEventListener("click", createAlbum);
	document.getElementById("add-category-submit").addEventListener("click", createCategory);
	document.getElementById("add-picture-submit").addEventListener("click", addPictureToAlbum);
	document.getElementById("rate-album-submit").addEventListener("click", rateAlbum);
	document.getElementById("rate-picture-submit").addEventListener("click", ratePicture);
	document.getElementById("add-picture-comment-button").addEventListener("click", addCommentToPicture);
	// document.getElementById("search-button").addEventListener("click", performSearch);

	$("#search").submit(function() {
		performSearch();
		return false;
	});

	$('#filters-category').change(function(data) {
		var selected;
		var albumList = $('#album-list').children();

		$("#filters-category option:selected").each(function() {
			selected = $(this).val();
		});

		if (selected !== 'all') {
			albumList.show();
			albumList.each(function(number, element) {
				if ($(element).data('container') !== selected) {
					$(element).hide();
				}
			});
		} else {
			albumList.show();
		}
	});

	$('#filters-rating').change(function(data) {
		var selected;
		var albumList = $('#album-list').children();

		$("#filters-rating option:selected").each(function() {
			selected = $(this).val();
		});

		switch (selected) {
		case 'Rating (ascending)':
			albumList.sort(sortByRatingAsc);
			albumList.each(function(x, element) {
				$('#album-list').append(element);
			});
			break;
		case 'Rating (descending)':
			albumList.sort(sortByRatingDes);
			albumList.each(function(x, element) {
				$('#album-list').append(element);
			});
			break;
		case 'Date (ascending)':
			albumList.sort(sortByDateAsc);
			albumList.each(function(x, element) {
				$('#album-list').append(element);
			});
			break;
		case 'Date (descending)':
			albumList.sort(sortByDateDes);
			albumList.each(function(x, element) {
				$('#album-list').append(element);
			});
			break;

		default:
			break;
		}
	});

	$('#filters-rating-picture').change(function(data) {
		var selected;
		var pictureList = $('#album-images-container').children();

		$("#filters-rating-picture option:selected").each(function() {
			selected = $(this).val();
		});

		switch (selected) {
		case 'Rating (ascending)':
			pictureList.sort(sortByRatingAsc);
			pictureList.each(function(x, element) {
				$('#album-images-container').append(element);
			});
			break;
		case 'Rating (descending)':
			pictureList.sort(sortByRatingDes);
			pictureList.each(function(x, element) {
				$('#album-images-container').append(element);
			});
			break;
		case 'Date (ascending)':
			pictureList.sort(sortByDateAsc);
			pictureList.each(function(x, element) {
				$('#album-images-container').append(element);
			});
			break;
		case 'Date (descending)':
			pictureList.sort(sortByDateDes);
			pictureList.each(function(x, element) {
				$('#album-images-container').append(element);
			});
			break;

		default:
			break;
		}
	});

	$('#image-file').change(function() {
		$('#max-file-size').css('color', 'black');
		$('#allowed-file-types').css('color', 'black');
	});

	$('#main-container').on('click', '.album', Dom.openAnAlbum);

	function sortByRatingAsc(x, y) {
		var a = typeof ($(x).data('rating')) !== 'undefined' ? $(x).data('rating').reduce(function(pv, cv) {
			return parseInt(pv) + parseInt(cv);
		}, 0) / $(x).data('rating').length : -1;
		var b = typeof ($(y).data('rating')) !== 'undefined' ? $(y).data('rating').reduce(function(pv, cv) {
			return parseInt(pv) + parseInt(cv);
		}, 0) / $(y).data('rating').length : -1;

		if (a === b) {
			if ($(x).attr('id') < $(y).attr('id')) {
				return -1;
			}
			if ($(x).attr('id') > $(y).attr('id')) {
				return 1;
			}
		}

		return a - b;
	}

	function sortByRatingDes(x, y) {
		return sortByRatingAsc(y, x);
	}

	function sortByDateAsc(x, y) {
		var a = Date.parse($(x).data('date'));
		var b = Date.parse($(y).data('date'));

		return a - b;
	}

	function sortByDateDes(x, y) {
		return sortByDateAsc(y, x);
	}

}

function createPictureItem(pic) {
	var ul = $('#album-images-container');

	var url = pic.file.url;
	var picName = pic.name;
	var date = pic.createdAt.substr(0, 10);
	var dateArr = date.split('-');
	var picDate = "Date: " + dateArr[2] + '.' + dateArr[1] + '.' + dateArr[0];
	var picId = pic.objectId;

	var header = $('<header>');
	var h3 = $('<h3>');
	var section = $('<section>');
	var footer = $('<footer>');
	var img = $('<img>');
	var a = $('<a>');

	h3.text(picName);
	img.attr('src', url);
	a.attr('href', url).attr('download', picName).text('Download');

	header.append(h3);

	section.append(img).append($('<div>').attr('class', 'pic-hover').attr('data-id', picId).attr('data-src', url));

	footer.append($('<section>').attr('class', 'pic-date').text(picDate)).append($('<section>').attr('class', 'pic-download').append(a)).append($('<section>').attr('id', picId).attr('class', 'pic-rating').text('Rate me'));

	var li = $('<li>');
	li.data('date', pic.createdAt);
	li.data('id', pic.objectId);
	li.data('rating', 'undefined');

	ul.append(li.append(header).append(section).append(footer));
	appendPictureToAlbumInAlbumView(url)
}

function appendPictureToAlbumInAlbumView(picUrl) {
	var openedAlbum = document.getElementById('opened-album-title');
	var albumId = openedAlbum.getAttribute('class');
	var pictureLiInAlbumView = $('#' + albumId + " div.album-pic-holder ul li");

	if (pictureLiInAlbumView.length < 4) {
		$('#' + albumId + " div.album-pic-holder ul").first().append($('<li>').append($('<img>').attr('src', picUrl)));
	} else {
		$('#' + albumId + " div.album-pic-holder ul").first().append($($('<li>').append($('<img>').attr('src', picUrl))).hide());
	}
}

$(function() {
	attachEventes();
	$('.fadein').hide();
	$('.fadein').fadeIn(800);

});

