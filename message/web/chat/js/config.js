//// MySQL API
var apis = 'api.php'; 

// set image directori
var imageDir = 'image';

// Replace with: your firebase account
var config = {
    apiKey: "AIzaSyDfKpgAUCOja3z-tc0yHOqzOCEGo0seJAQ",
    databaseURL: "https://chatws-40480.firebaseio.com",
//        apiKey: "AIzaSyCpp4RSDzBsS_Ovf4j5P4EWBv7BHhrt8S4",
//        databaseURL: "https://giataivuon-7963a.firebaseio.com",
};
firebase.initializeApp(config);

// create firebase child
var dbRef = firebase.database().ref(),
	messageRef = dbRef.child('message'),
	userRef = dbRef.child('user');
messageRef.on('value', function(snapshot) {
   console.log(JSON.stringify(snapshot.val()));
});

// MySQL API
//var apis = 'api.php';
//
//// set image directori
//var imageDir = 'image';
//
//// Replace with: your firebase account
//var config = {
//    apiKey: "AIzaSyCpp4RSDzBsS_Ovf4j5P4EWBv7BHhrt8S4",
////    authDomain: "giataivuon-7963a.firebaseapp.com",
//    databaseURL: "https://giataivuon-7963a.firebaseio.com",
////    projectId: "giataivuon-7963a",
////    storageBucket: "giataivuon-7963a.appspot.com",
////    messagingSenderId: "879153894229"
//};
//firebase.initializeApp(config);
//
//// create firebase child
//var dbRef = firebase.database().ref(),
//        messageRef = dbRef.child('message'),
//        userRef = dbRef.child('user');


