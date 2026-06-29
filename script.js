// Already included in index.php for timer; additional global helpers
function showToast(msg) {
    let toast = document.createElement('div'); toast.className='toast'; toast.innerText=msg;
    document.body.appendChild(toast); setTimeout(()=>toast.remove(),2000);
}