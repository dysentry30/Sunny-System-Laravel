<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Proyek XML</title>
</head>
<body>
    <script>
        const email = prompt("Email");
        const password = prompt("Password");
        login();
        async function login() {
            const formData = new FormData();
            formData.append("email", email);
            formData.append("password", password);
            formData.append("_token", "{{csrf_token()}}");
            const loginRes = await fetch("/login", {
                method: "POST",
                headers: {
                    // "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
                body: formData,
            }).then(res => res.json());
            console.log(loginRes);
            if(loginRes.is_success) {
                await getDetailProyekXML()
                return;
            }
            window.location.href = "/abort/401/Unauthorized";
            return;
        }

        async function getDetailProyekXML() {
            const loginRes = await fetch("/get-proyek-xml").then(res => res.blob());
            console.log(loginRes);
            const aElt = document.createElement("a");
            document.body.appendChild(aElt);
            url = window.URL.createObjectURL(loginRes);
            aElt.href = url;
            const date = new Date();
            aElt.download = `get-detail-proyek-${date.getDate()}${date.getMonth()}${date.getFullYear()}${date.getHours()}${date.getMinutes()}${date.getSeconds()}.xml`;
            aElt.click();
            window.URL.revokeObjectURL(url);
        }
    </script>
</body>
</html>