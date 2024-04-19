import * as React from "react";
import CRMRoot from "../../window-context-service.jsx";

const TwoFAEnrollmentWelcome: React.FunctionComponent<{
  nextButtonEventHandler: Function;
}> = ({ nextButtonEventHandler }) => {
  return (
    <div className="col-lg-12">
        <div className="box" id="TwoFAEnrollmentSteps">
          <div className="box-body">
            <p>
              {window.i18next.t(
                "Enrolling your CommunityCRM user account in Two Factor Authention provides an additional layer of defense against bad actors trying to access your account.",
              )}
            </p>
            <p>
              {window.i18next.t(
                "CommunityCRM Two factor supports any TOTP authenticator app, so you're free to choose between Microsoft Authenticator, Google Authenticator, Authy, LastPass, and others",
              )}
            </p>
            <hr />
            <div className="col-lg-4">
              <i className="fa fa-id-card"></i>
              <p>
                {window.i18next.t(
                  "When you sign in to CommunityCRM, you'll still enter your username and password like normal",
                )}
              </p>
            </div>
            <div className="col-lg-4">
              <i className="fa fa-key"></i>
              <p>
                {window.i18next.t(
                  "However, you'll also need to supply a one-time code from your authenticator device to complete your login",
                )}
              </p>
            </div>
            <div className="col-lg-4">
              <i className="fa fa-square-check"></i>
              <p>
                {window.i18next.t(
                  "After successfully entering both your credentials, and the one-time code, you'll be logged in as normal",
                )}
              </p>
            </div>
            <div className="clearfix"></div>
            <div className="callout callout-warning">
              <p>
                {window.i18next.t(
                  "To prevent being locked out of your CommunityCRM account, please ensure you're ready to complete two factor enrollment before clicking begin",
                )}
              </p>
            </div>
            <ul>
              <li>
                {window.i18next.t(
                  "Beginning enrollment will invalidate any previously enrolled 2 factor devices and recovery codes.",
                )}
              </li>
              <li>
                {window.i18next.t(
                  "When you click next, you'll be prompted to scan a QR code to enroll your authenticator app.",
                )}
              </li>
              <li>
                {window.i18next.t(
                  "To confirm enrollment, you'll need to enter the code generated by your authenticator app",
                )}
              </li>
              <li>
                {window.i18next.t(
                  "After confirming app enrollment, single-use recovery codes will be generated and displayed.",
                )}
                <ul>
                  <li>
                    {window.i18next.t(
                      "Recovery codes can be used instead of a code generated from your authenticator app.",
                    )}
                  </li>
                  <li>
                    {window.i18next.t("Store these in a secure location")}
                  </li>
                </ul>
              </li>
            </ul>

            <div className="clearfix"></div>
            <button
              id="begin2faEnrollment"
              className="btn btn-success"
              onClick={() => {
                nextButtonEventHandler();
              }}
            >
              {window.i18next.t("Begin Two Factor Authentication Enrollment")}
            </button>
          </div>
        </div>
      </div>
  );
};

const TwoFAEnrollmentGetQR: React.FunctionComponent<{
  TwoFAQRCodeDataUri: string;
  newQRCode: Function;
  remove2FA: Function;
  validationCodeChangeHandler: (
    event: React.ChangeEvent<HTMLInputElement>,
  ) => void;
  currentTwoFAPin?: string;
  currentTwoFAPinStatus: string;
}> = ({
  TwoFAQRCodeDataUri,
  newQRCode,
  remove2FA,
  validationCodeChangeHandler,
  currentTwoFAPin,
  currentTwoFAPinStatus,
}) => {
  return (
    <div className="col-lg-12">
        <div className="box">
          <div className="box-header">
            <h4>{window.i18next.t("2 Factor Authentication Secret")}</h4>
          </div>
          <div className="box-body">
            <div className="col-lg-6">
              <img id="2faQrCodeDataUri" src={TwoFAQRCodeDataUri}  alt="2FA QR Code Data URI" />
            </div>
            <div className="col-lg-6">
              <div className="row">
                <div className="col-lg-6">
                  <button
                    className="btn btn-warning"
                    onClick={() => {
                      newQRCode();
                    }}
                  >
                    {window.i18next.t(
                      "Regenerate 2 Factor Authentication Secret",
                    )}
                  </button>
                </div>
                <div className="col-lg-6">
                  <button
                    className="btn btn-warning"
                    onClick={() => {
                      remove2FA();
                    }}
                  >
                    {window.i18next.t("Remove 2 Factor Authentication Secret")}
                  </button>
                </div>
              </div>
              <div className="row">
                <div className="col-lg-12">
                  <label>
                    {window.i18next.t("Enter TOTP code to confirm enrollment")}:
                    <input
                      onChange={validationCodeChangeHandler}
                      value={currentTwoFAPin}
                      autoFocus
                    />
                  </label>
                  <p>{currentTwoFAPinStatus}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  );
};

const TwoFAEnrollmentSuccess: React.FunctionComponent<{
  TwoFARecoveryCodes?: string[];
}> = ({ TwoFARecoveryCodes }) => {
  return (
    <div className="col-lg-12">
      <div className="box">
        <div className="box-header">
          <h4>
            {window.i18next.t("2 Factor Authentication Enrollment Success")}
          </h4>
        </div>
        <div className="box-body">
          <p>
            {window.i18next.t(
              "Please store these recovery codes in a safe location",
            )}
          </p>
          <p>
            {window.i18next.t(
              "If you ever lose access to your newly enrolled authenticator app, you'll need to use a recovery code to gain access to your account",
            )}
          </p>
          <ul>
            {TwoFARecoveryCodes.length ? (
              TwoFARecoveryCodes.map((code) => <li>{code}</li>)
            ) : (
              <p>waiting</p>
            )}
          </ul>
        </div>
      </div>
    </div>
  );
};

class UserTwoFactorEnrollment extends React.Component<
  TwoFactorEnrollmentProps,
  TwoFactorEnrollmentState
> {
  constructor(props: TwoFactorEnrollmentProps) {
    super(props);

    this.state = {
      currentView: "intro",
      TwoFARecoveryCodes: [],
    };

    this.nextButtonEventHandler = this.nextButtonEventHandler.bind(this);
    this.requestNew2FABarcode = this.requestNew2FABarcode.bind(this);
    this.remove2FAForuser = this.remove2FAForuser.bind(this);
    this.validationCodeChangeHandler =
      this.validationCodeChangeHandler.bind(this);
    this.requestNew2FARecoveryCodes =
      this.requestNew2FARecoveryCodes.bind(this);
  }

  nextButtonEventHandler() {
    this.requestNew2FABarcode();
    this.setState({
      currentView: "BeginEnroll",
    });
  }

  requestNew2FABarcode() {
    fetch(CRMRoot + "/api/user/current/refresh2fasecret", {
      credentials: "include",
      method: "POST",
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
      },
    })
      .then((response) => response.json())
      .then((data) => {
        this.setState({ TwoFAQRCodeDataUri: data.TwoFAQRCodeDataUri });
      });
  }

  requestNew2FARecoveryCodes() {
    fetch(CRMRoot + "/api/user/current/refresh2farecoverycodes", {
      credentials: "include",
      method: "POST",
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
      },
    })
      .then((response) => response.json())
      .then((data) => {
        this.setState({ TwoFARecoveryCodes: data.TwoFARecoveryCodes });
      });
  }

  remove2FAForuser() {
    fetch(CRMRoot + "/api/user/current/remove2fasecret", {
      credentials: "include",
      method: "POST",
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
      },
    })
      .then((response) => response.json())
      .then((data) => {
        this.setState({
          TwoFAQRCodeDataUri: "",
          currentView: "intro",
        });
      });
  }

  validationCodeChangeHandler(event: React.ChangeEvent<HTMLInputElement>) {
    this.setState({
      currentTwoFAPin: event.currentTarget.value,
    });
    if (event.currentTarget.value.length == 6) {
      console.log("Checking for valid pin");
      fetch(CRMRoot + "/api/user/current/test2FAEnrollmentCode", {
        credentials: "include",
        method: "POST",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ enrollmentCode: event.currentTarget.value }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.IsEnrollmentCodeValid) {
            this.requestNew2FARecoveryCodes();
            this.setState({
              currentView: "success",
            });
          } else {
            this.setState({
              currentTwoFAPinStatus: "invalid",
            });
          }
        });
      this.setState({
        currentTwoFAPinStatus: "pending",
      });
    } else {
      this.setState({
        currentTwoFAPinStatus: "incomplete",
      });
    }
  }

  render() {
    if (this.state.currentView === "intro") {
      return (
          <div className="row">
            <TwoFAEnrollmentWelcome
              nextButtonEventHandler={this.nextButtonEventHandler}
            />
          </div>
      );
    } else if (this.state.currentView === "BeginEnroll") {
      return (
          <div className="row">
            <TwoFAEnrollmentGetQR
              TwoFAQRCodeDataUri={this.state.TwoFAQRCodeDataUri}
              newQRCode={this.requestNew2FABarcode}
              remove2FA={this.remove2FAForuser}
              validationCodeChangeHandler={this.validationCodeChangeHandler}
              currentTwoFAPin={this.state.currentTwoFAPin}
              currentTwoFAPinStatus={this.state.currentTwoFAPinStatus}
            />
          </div>
      );
    } else if (this.state.currentView === "success") {
      return (
        <TwoFAEnrollmentSuccess
          TwoFARecoveryCodes={this.state.TwoFARecoveryCodes}
        />
      );
    } else {
      return <h4>Uh-oh</h4>;
    }
  }
}

interface TwoFactorEnrollmentProps {}

interface TwoFactorEnrollmentState {
  currentView: string;
  TwoFAQRCodeDataUri?: string;
  currentTwoFAPin?: string;
  currentTwoFAPinStatus?: string;
  TwoFARecoveryCodes: string[];
}
export default UserTwoFactorEnrollment;
