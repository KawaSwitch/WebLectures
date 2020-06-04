
function onSignIn(googleUser) 
{
	var profile = googleUser.getBasicProfile();
	console.log('ID: ' + profile.getId());
	console.log('Name: ' + profile.getName());
	console.log('Image URL: ' + profile.getImageUrl());
	console.log('Email: ' + profile.getEmail());

	var id_token = googleUser.getAuthResponse().id_token;
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'index.php?event=checkLogin');
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

	xhr.onload = function() {
		console.log('Signed in as: ' + xhr.responseText);
	};

	// IDトークンをサーバ側へ渡す
	xhr.send('id_token=' + id_token);

	window.location.href = 'index.php?event=showInputPage';
}

function signOut() 
{
    gapi.load('auth2', function () {
		gapi.auth2.init().then(function () {
			var auth2 = gapi.auth2.getAuthInstance();
			auth2.signOut().then(function () {
				auth2.disconnect();
				console.log('User signed out.');
			});
		});
	});
}
