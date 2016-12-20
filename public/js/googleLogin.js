function loginWithGoogle(language){
    google_signIn(language);
}
function google_signIn(language) {
    gapi.client.load('plus', 'v1', function () {
        var request = gapi.client.plus.people.get({
            'userId': 'me'
        });
        //Display the user details
        request.execute(function (resp) {
            $.ajax({
                url: '/'+language+'/welcome/google_login',
                type: 'POST',
                data: {
                    id: resp.id, 
                    email: resp.emails[0].value, 
                    name: resp.name.givenName, 
                    lastname: resp.name.familyName
                },
                success: function (data) {
                    var jsonData = $.parseJSON(data);
                    if (jsonData.userid.length > 0) {
                      window.location.href = jsonData.redirectUrl +jsonData.language+'/welcome/user_page';
                    }else{
                        
                    }

                }
            });
        });
    });
}





