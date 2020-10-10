module.exports = async (ip, user) => {
    var today = new Date();

    var xml = new XMLHttpRequest();
    xml.open('GET', `https://ipinfo.io/${ip}?token=${config.token}`, true);
    xml.send();
    xml.onreadystatechange = async function () {
        if (xml.readyState == 4 && xml.status == 200) {
            var data = JSON.parse(xml.responseText);

            if (today.getMinutes() < 10) {
                var min = "0" + today.getMinutes();
            } else {
                var min = today.getMinutes()
            }
            ;
            if (today.getHours() < 10) {
                var hou = "0" + today.getHours();
            } else {
                var hou = today.getHours()
            }
            ;

            today = await `${hou}:${min} (${today.getDate()}/${today.getMonth() + 1}/${today.getFullYear()})`;

            userInfo[today] = new Array();

            for (i in data) {
                userInfo[today].push(data[i]);
            }

            let checkDevice = require(`${__dirname}/modules/checkDevice.js`);
            await checkDevice(user);

            var ip = userInfo[today].splice(0, 1);
            var domain = userInfo[today].splice(0, 1);
            console.log(ip);
            fs.writeFileSync(`${__dirname}/userInfo.json`, JSON.stringify(userInfo));
        } else {
            console.log(xml.status);
        }
    };
}