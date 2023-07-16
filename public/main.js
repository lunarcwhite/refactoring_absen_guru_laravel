let VIDEO = null;
let CANVAS = null;
let CONTEXT = null;

function main() {
    CANVAS = document.getElementById("myCanvas");
    CONTEXT = CANVAS.getContext("2d");
    CANVAS.width = window.innerWidth;
    CANVAS.height = window.innerHeight;
    let promise = navigator.mediaDevices.getUserMedia({
        video: true,
    });
    promise.then((signal) => {
        VIDEO = document.createElement("video");
        VIDEO.srcObject = signal;
        VIDEO.play();
        VIDEO.onloadeddata = () => {
            updateCanvas();
        }
    }).catch((err) => {
        alert(err)
    })
}

function updateCanvas(){
    CONTEXT.drawImage(VIDEO, 0, 0);
    window.requestAnimationFrame(updateCanvas);
}
