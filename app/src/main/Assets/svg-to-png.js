var svg  = document.getElementById('graph'),
    xml  = new XMLSerializer().serializeToString(svg),
    data = "data:image/svg+xml;base64," + btoa(xml),
    img  = new Image()

img.setAttribute('src', data)
document.body.appendChild(img)
