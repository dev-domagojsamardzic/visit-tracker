class YTracker {

    endpoint = 'http://localhost/track.php';
    cookieName = 'ytvid';
    expiresAfterDays = 365;

    constructor() {
        // check if cookie exists
        this.visitorID = this.getOrSetVisitorId();
        this.recordVisit();
    }

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

    setCookie(name, value) {
        const d = new Date();
        // Set expiration time
        d.setTime(d.getTime() + (this.expiresAfterDays * 24 * 60 * 60 * 1000));
        // Format expiration time
        const expires = d.toUTCString();
        // Set the cookie
        document.cookie = `${name}=${value};expires=${expires};path=/;SameSite=Lax`;
    }

    getCookie(name) {

        const nameEquals = `${name}=`;
        // Split cookies string by ;
        const cookieElements = document.cookie.split(';');

        // Loop through key value pairs
        for (let i = 0; i < cookieElements.length; i++) {
            let element = cookieElements[i].trim();
            // Check for existence of nameEquals string in key-value pair
            if (element.indexOf(nameEquals) === 0) {
                return element.substring(nameEquals.length, element.length); // Return the value of the cookie
            }
        }

        return '';
    }

    generateVisitorId() {
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let string = '';
        for (let i = 0; i < 10; i++) {
            string += characters.charAt(Math.floor(Math.random() * characters.length));
        }
        return string;
    }

    recordVisit() {
        const data = {
            visitor_id: this.visitorID
        }
        console.log('sending data: '+ JSON.stringify(data))
        fetch(this.endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json', // Ensure correct headers
            },
            body: JSON.stringify(data)
        })
            .then(response => response.text())
            .then(result => {
                console.log(result); // Log the response
            })
            .catch(error => {
                console.error('Error:', error); // Catch and log any errors
            });
    }
}

// Init YTracker on DOMContentLoaded event
document.addEventListener('DOMContentLoaded', () => {
    window.YTracker = new YTracker();
})