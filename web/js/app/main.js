function escalationFrontend(){
    $(".btn.btn-navbar.collapsed").click(function(){
        toggleArrowUpAndDown($(this));
    });
    fnShowTooltip("left");
}
function escalationBackend() {
    fnShowTooltip("left");
}
function toggleArrowUpAndDown (btn) {
    btn.find("i.icon-large").toggleClass("icon-circle-arrow-down");
    btn.find("i.icon-large").toggleClass("icon-circle-arrow-up");
}
function fnLoginLayout() {
    debugger;
    var oVUsernameLogin = new LiveValidation("signin_username", {
        validMessage: " "
    });
    addValidatePresence(oVUsernameLogin, {
        failureMessage: "Username is required"
    });
    var oVPasswordLogin = new LiveValidation("signin_password", {
        validMessage: " "
    });
    addValidatePresence(oVPasswordLogin, {
        failureMessage: "Password is required"
    });
    // button loading fancy way
    $('.btn.btn-info-purple').on("click", function() {
        var btn = $(this);
        btn.button('loading');
        if ($("#signin_username").val() === "" || $("#signin_password").val() == "") {
            btn.button("reset");
        }
    });
}