class YTracker {

    // TODO: You could pass these properties via constructor as options for further modularity
    /**
     * @type {string}
     */
    endpoint = 'http://localhost/track.php';
    /**
     * Y(omali)(T)racker(V)isitor(ID)
     * @type {string}
     */
    cookieName = 'ytvid';
    /**
     * @type {number}
     */
    expiresAfterDays = 365;

    constructor() {
        // check if cookie exists
        this.visitorID = this.getOrSetVisitorId();
        this.recordVisit();
    }

    /**
     * Get visitor id from cookie, or set one and return
     * @returns {string}
     */
    getOrSetVisitorId() {

        let visitorId;

        if (document.cookie.indexOf(this.cookieName) === -1) {
            visitorId = this.generateVisitorId();
            this.setCookie(this.cookieName, visitorId);
        }
        else {
            visitorId = this.getCookie(this.cookieName);
        }

        return visitorId;
    }

    /**
     * Set cookie
     * @param name
     * @param value
     */
    setCookie(name, value) {
        const d = new Date();
        // Set expiration time
        d.setTime(d.getTime() + (this.expiresAfterDays * 24 * 60 * 60 * 1000));
        // Format expiration time
        const expires = d.toUTCString();
        // Set the cookie
        document.cookie = `${name}=${value};expires=${expires};path=/;SameSite=Lax`;
    }

    /**
     * Get cookie
     * @param name
     * @returns {string}
     */
    getCookie(name) {

        const nameEquals = `${name}=`;
        // Split cookies string by ;
        const cookieElements = document.cookie.split(';');

        // Loop through key value pairs
        for (let i = 0; i < cookieElements.length; i++) {
            let element = cookieElements[i].trim();
            // Check for existence of nameEquals string in key-value pair
            if (element.indexOf(nameEquals) === 0) {
                return element.substring(nameEquals.length, element.length);
            }
        }

        return '';
    }

    /**
     * Generate random string (visitor_id)
     * @returns {string}
     */
    generateVisitorId() {

        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

        let string = '';
        for (let i = 0; i < 10; i++) {
            string += characters.charAt(Math.floor(Math.random() * characters.length));
        }

        return string;
    }

    /**
     * Send request to track endpoint, record a visit
     */
    recordVisit() {

        const data = {
            visitor_id: this.visitorID,
            page: window.location.href
        }

        fetch(this.endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json', // Ensure correct headers
            },
            body: JSON.stringify(data)
        })
            // console log and console error is for testing purposes
            .then(response => response.text())
            .then(result => console.log(result))
            .catch(error => console.error('Error:', error));
    }
}

// Init YTracker on DOMContentLoaded event
document.addEventListener('DOMContentLoaded', () => {
    window.YTracker = new YTracker();
})