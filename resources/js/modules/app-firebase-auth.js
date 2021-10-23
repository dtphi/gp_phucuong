window.auth = undefined;
window.recaptchaVerifier = undefined;
//window.confirmationResult

const firebaseConfig = {
  apiKey: "",
  authDomain: "",
  projectId: "",
  storageBucket: "",
  messagingSenderId: "",
  appId: "",
  measurementId: ""
};

let lang = 'vi';
let appVerificationDisabledForTesting = false;// true or false
let testPhoneNumber = "+84";
let testVerificationCode = '';
let RecaptchaVerifier = undefined;

let _getFbConfig = function() {
    return firebaseConfig;
}

function _initAuth(fbAuth, recapVerifier) {
  auth = fbAuth;
  auth.languageCode = lang;
  auth.settings.appVerificationDisabledForTesting = appVerificationDisabledForTesting;
  if (appVerificationDisabledForTesting) {
    window.phoneNumber = testPhoneNumber;
    window.testVerificationCode = testVerificationCode;
  }

  RecaptchaVerifier = recapVerifier;

  return auth;
}

function _configRecaptcha() {
  recaptchaVerifier = new RecaptchaVerifier('recaptcha-container', {
    'size': 'invisible',
  }, auth);
}

function _startAuth(_sendVerifyCode) {
  sendVerifyCode = _sendVerifyCode;
  //if (!localStorage.getItem('myPage.expectSignIn')) showDialog()
  auth.onAuthStateChanged(user => {
    if (user) {
      // User just signed in, we should not display dialog next time because of firebase auto-login
      localStorage.setItem('linhMuc.expectSignIn', '1');
      localStorage.setItem('linhMuc.expectSignInPhone', user.phoneNumber);
      $('#container-firebase').children().remove();
      $('#container-firebase-logout').removeAttr('style');
      $('#user-phone-success').text(user.phoneNumber)
    } else {
      // User just signed-out or auto-login failed, we will show sign-in form immediately the next time he loads the page
      localStorage.removeItem('linhMuc.expectSignIn');
      localStorage.removeItem('linhMuc.expectSignInPhone');
      $('#container-firebase').removeAttr('style');
      $('#container-firebase-logout').children().remove();

      // Here implement logic to trigger the login dialog or redirect to sign-in page, if necessary. Don't redirect if dialog is already visible.
      // e.g. showDialog()
    }
  });
}

function _getPhoneNumber() {
  var _checkPhone = function(strPhone) {
    if (/(84|0[3|5|7|8|9])+([0-9]{8})\b/g.test(strPhone)) {
    return true;
    } else {
    return false;
    }
  }
  // vi: +84
  var phone = '';
  if (Number($("#numberPhone").val()))
    phone = Number($("#numberPhone").val());
  if (_checkPhone($("#numberPhone").val())) {
    phone = '+84'+ phone;
  } else {
    phone = "invalid_phone";
  }
    
  console.log(phone)
  return phone;
}

window.sendOTP = function() {
  //e.preventDefault();
  _configRecaptcha();

  var phoneNum = (_getPhoneNumber())? _getPhoneNumber(): testPhoneNumber;  
  
  if (auth.settings.appVerificationDisabledForTesting) {
    phoneNum = testPhoneNumber;
  } else {
    if (phoneNum === "invalid_phone")
      return;
  }
  const appVerifier = window.recaptchaVerifier;
  console.log(phoneNum, appVerifier);
  sendVerifyCode(auth, phoneNum, appVerifier).then(function (confirmationResult) {
      window.confirmationResult = confirmationResult;
      if (auth.settings.appVerificationDisabledForTesting) {
        var code = testVerificationCode;console.log('confirm:', confirmationResult)
        confirmationResult.confirm(code).then(function (result) {
            var user = result.user;
            alert('Nhập OTP từ số điện thoại:' + user.phoneNumber);
            window.location.reload();
        }).catch(function (error) {
          alert('Xác thực test ' + phoneNumber + ' không hợp lệ');
          $('div#user-info-varify button').attr('disabled', 'disabled');
        });
      }
      
      window.recaptchaVerifier = undefined;
      $('div#user-info-varify button').removeAttr('disabled');
      console.log('sendOTP sent',confirmationResult);
  }).catch(function (error) {
    let isTest = (auth.settings.appVerificationDisabledForTesting)?'test ':'';
    alert('Số điện thoại ' + isTest + ' :' + phoneNumber + ' không hợp lệ');
    $('div#user-info-varify button').attr('disabled', 'disabled');
  });
}

window.verifyOTP = function () {
  var code = $("#verification").val();
  if (confirmationResult) {
    confirmationResult.confirm(code).then(function (result) {
      var user = result.user;
      window.location.reload();
    }).catch(function (error) {
      alert('Xác thực thất bại gửi lại OTP');
      window.location.reload();
    });
  }
}

function sendVerifyCode() { return; };

export { _getFbConfig, _initAuth, _startAuth }