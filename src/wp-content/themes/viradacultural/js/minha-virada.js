minhaVirada = {
    
    uid: false,
    accessToken: false,
    eventId: false,
    connected: false,
    username: false,
    name: false,
    picture: false,
    events: false,
    
    connect: function(callback) {
        var callback = 'minhaVirada.' + callback + '()';
        
        if (minhaVirada.connected) {
            eval(callback);
            return;
        }
            
        
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                // the user is logged in and has authenticated your
                // app, and response.authResponse supplies
                // the user's ID, a valid access token, a signed
                // request, and the time the access token 
                // and signed request each expire
                
                minhaVirada.initializeUserData(response, callback);
            } else {
                // the user isn't logged in to Facebook.
                FB.login(function(response){
                    if (response.authResponse) {
                        // The person logged into your app
                        minhaVirada.initializeUserData(response, callback);
                    } else {
                        // The person cancelled the login dialog
                    }
                });
                
            }
        });
    },
    
    initializeUserData: function(response, callback) {
        
        minhaVirada.connected = true;
        minhaVirada.uid = response.authResponse.userID;
        minhaVirada.accessToken = response.authResponse.accessToken;
        
        //atualiza link no menu
        jQuery('#menu-minha-virada').attr('href', jQuery('#menu-minha-virada').attr('href') + '/' + minhaVirada.uid )
        
        FB.api('/me', {fields: ['name', 'username', 'picture.height(200)']}, function(response) {
            //console.log(response);
            minhaVirada.userame = response.username;
            minhaVirada.name = response.name;
            minhaVirada.picture = response.picture.data.url;
            
            // Pega eventos do usuário
            jQuery.post( vars.ajaxurl, {action: 'minhavirada_get_user_events', userid: minhaVirada.uid}, function( data ) {
                // não sei pq se usar o metodo getJSON ao inves de post, não funciona
                //console.log(data);
                minhaVirada.events = data;
                eval(callback);             
            });
            
            

        });
        
        

    },
    
    prepareJSON: function() {
        var json = {
            uid: minhaVirada.uid,
            picture: minhaVirada.picture,
            events: minhaVirada.events,
            name: minhaVirada.name
        }
        return json;
    },
    
    save: function() {
        var userJSON = minhaVirada.prepareJSON();
        jQuery.post( vars.ajaxurl, {action: 'minhavirada_updateJSON', dados: userJSON }, function( data ) {
            // atualiza estrelas
            
        });
    },
    
    // retorna falso se não tem, ou o índice se tem
    has_event: function(eventId) {
        for (var i = 0; i < minhaVirada.events.length; i++) {
            if (minhaVirada.events[i] == eventId)
                return i;
        }
        return false;
    },
    
    click: function(eventId) {
        minhaVirada.eventId = eventId;
        minhaVirada.connect('doClick');
    },
    
    doClick: function() {
        //console.log(minhaVirada.events);
        //console.log(minhaVirada.eventId);
        if (minhaVirada.eventId) {
            var has_event = minhaVirada.has_event(minhaVirada.eventId);
            if (has_event) {
                minhaVirada.events.splice(has_event, 1);
            } else {
                minhaVirada.events.push(minhaVirada.eventId);
            }
            minhaVirada.save();
        }
    }
}
