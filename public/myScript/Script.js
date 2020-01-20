$(document).ready(function () {
    $('#MydataTables').DataTable({
        destroy: true

    });
});




function onClickBtnListen(title) {
    console.log(title);
    $.ajax({
        method: "post",
        //url: '/audio/show',       
        data: { Title: title },
    }).done(function (response) {
        var url = "audio/show?Title=" + title;
        $(location).attr('href', url);
    }).fail(function (jxh, textmsg, errorThrown) {
        console.log('textmsg');
        console.log('errorThrown');
    });


}

function onClickDownloadOne(title, event) {

    alert(title);
    $.ajax({
        method: "post",
        data: { Title: title },
    }).done(function (response) {
        var url = "/audio/donwloadFile?Title=" + title;
        $(location).attr('href', url);
    }).fail(function (jxh, textmsg, errorThrown) {
        alert('failed');
        console.log('textmsg');
        console.log('errorThrown');
    });
}


function onClickBtnDownloadAll() {
    $.ajax({
        method: "post",
    }).done(function (response) {
        var url = "/audio/downloadAll";
        $(location).attr('href', url);
    }).fail(function (jxh, textmsg, errorThrown) {
        alert('failed');
    });

}

function onClickBtnSendImageName() {
    var name = document.querySelector("#fileToUpload").files[0].name;
    console.log(name);
    $.ajax({
        method: "post",
        data: { name: name },
    }).done(function (response) {
        var url = "/register";
        $(location).attr('href', url);
    }).fail(function (jxh, textmsg, errorThrown) {
        alert('failed');
    });
}


function onClickBtnUpload() {
    console.log('you called me');
    var name = document.querySelector("#fileToUpload").files[0].name;
    console.log(name);
    $.ajax({
        method: "post",
    }).done(function (response) {
        var url = "/register/upload";
        $(location).attr('href', url);
    }).fail(function (jxh, textmsg, errorThrown) {
        alert('failed');
    });
}

















