document.getElementById('trade-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const tradeType = document.getElementById('trade_type').value;
    const tradeAmount = document.getElementById('trade_amount').value;
    tradeResources(tradeType, tradeAmount);
});

function tradeResources(tradeType, tradeAmount) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'trade_resources.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById('trade-status').innerText = xhr.responseText;
        }
    };
    xhr.send(`trade_type=${encodeURIComponent(tradeType)}&trade_amount=${encodeURIComponent(tradeAmount)}`);
}
