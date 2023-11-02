function resetForm()
{
    window.location.href = window.location.origin+window.location.pathname;
    // window.location.reload();
}    
function copyToClipboard(selector)
{
    var copyText = document.getElementById(selector);
    // Copy the text inside the text field
    navigator.clipboard.writeText(copyText.value);

    generateToast("text-bg-primary", "Copied to Clipboard!");
    
}
function generateToast(cls, msg)
{
    document.getElementById('toast_message').innerHTML = msg;
    const myToastEl = document.getElementById('liveToast');
    myToastEl.classList.add(cls);
    const tost = new bootstrap.Toast(myToastEl);
    tost.show();
}