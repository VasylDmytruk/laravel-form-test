
export default class DateTimeHelper {

    static getFormattedTime(timeToFormat) {
        const minutes = parseInt(timeToFormat / 60);
        const seconds = timeToFormat % 60;

        const formattedTime = `${minutes} m ${seconds} s`;

        return formattedTime;
    }
}