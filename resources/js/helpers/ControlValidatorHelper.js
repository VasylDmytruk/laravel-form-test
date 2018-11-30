export default class ControlValidatorHelper {
    static setErrors(control, errors) {
        control.hasErrors = true;
        control.validationErrors = errors;
    }

    static resetErrors(control) {
        control.hasErrors = false;
        control.validationErrors = [];
    }
}