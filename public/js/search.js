// this is for seach judge to assign and select event to assign
document.addEventListener("DOMContentLoaded", function() {
    const eventSelect = document.getElementById('event_id');
    const eventSearch = document.getElementById('eventSearch');

    eventSearch.addEventListener('input', function() {
        const searchTerm = eventSearch.value.toLowerCase();
        Array.from(eventSelect.options).forEach(function(option) {
            const eventName = option.text.toLowerCase();
            if (eventName.includes(searchTerm)) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        });
    });

    const judgeSelect = document.getElementById('judge_id');
    const judgeSearch = document.getElementById('judgeSearch');

    judgeSearch.addEventListener('input', function() {
        const searchTerm = judgeSearch.value.toLowerCase();
        Array.from(judgeSelect.options).forEach(function(option) {
            const judgeName = option.text.toLowerCase();
            if (judgeName.includes(searchTerm)) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        });
    });
});