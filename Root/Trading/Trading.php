<div id="trade-section" style="display: none;">
    <h2>Trade Resources</h2>
    <form id="trade-form">
        <label for="trade_type">Trade Type:</label>
        <select id="trade_type" name="trade_type">
            <option value="metal">Metal</option>
            <option value="crystal">Crystal</option>
            <option value="deuterium">Deuterium</option>
        </select>
        <label for="trade_amount">Amount:</label>
        <input type="number" id="trade_amount" name="trade_amount" required>
        <button type="submit">Trade</button>
    </form>
    <div id="trade-status"></div>
</div>
