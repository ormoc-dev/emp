document.addEventListener("DOMContentLoaded", function() {

    // Chart options
    const getChartOptions = () => {
        return {
            series: [contestantsCount, eventCounts, pendingEvents.length], // Set the contestants count as the first series data
            colors: ["#1C64F2", "#16BDCA", "#9061F9"],
            chart: {
                height: 420,
                width: "100%",
                type: "pie",
            },
            stroke: {
                colors: ["white"],
                lineCap: "",
            },
            plotOptions: {
                pie: {
                    labels: {
                        show: true,
                    },
                    size: "100%",
                    dataLabels: {
                        offset: -25
                    }
                },
            },
            labels: ["Contestants", "Events", "Pending events"],
            dataLabels: {
                enabled: true,
                style: {
                    fontFamily: "Inter, sans-serif",
                },
            },
            legend: {
                position: "bottom",
                fontFamily: "Inter, sans-serif",
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return value + "%"
                    },
                },
            },
            xaxis: {
                labels: {
                    formatter: function (value) {
                        return value + "%"
                    },
                },
                axisTicks: {
                    show: false,
                },
                axisBorder: {
                    show: false,
                },
            },
        };
    };

    // Render chart if element exists
    const pieChart = document.getElementById("pie-chart");
    if (pieChart && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(pieChart, getChartOptions());
        chart.render();
    }

    // Filter dropdown functionality
    const filterIcon = document.getElementById('filterIcon');
    const filterDropdown = document.getElementById('filterDropdown');
    if (filterIcon && filterDropdown) {
        filterIcon.addEventListener('click', function() {
            filterDropdown.style.display = (filterDropdown.style.display === 'none' || !filterDropdown.style.display) ? 'block' : 'none';
        });
    }

    // Widget dropdown functionality
    const widgetDropdownButton = document.getElementById("widgetDropdownButton");
    const widgetDropdown = document.getElementById("widgetDropdown");
    if (widgetDropdownButton && widgetDropdown) {
        widgetDropdownButton.addEventListener("click", function() {
            widgetDropdown.classList.toggle("hidden");
        });
    }

    // Last days dropdown functionality
    const lastDaysDropdownButton = document.getElementById("dropdownDefaultButton");
    const lastDaysDropdown = document.getElementById("lastDaysdropdown");
    if (lastDaysDropdownButton && lastDaysDropdown) {
        lastDaysDropdownButton.addEventListener("click", function() {
            lastDaysDropdown.classList.toggle("hidden");
        });
    }

    // Tooltip functionality
    const tooltipIcon = document.querySelector('[data-popover-target="chart-info"]');
    const tooltip = document.getElementById('chart-info');
    if (tooltipIcon && tooltip) {
        tooltipIcon.addEventListener("click", function() {
            tooltip.classList.toggle("invisible");
            tooltip.classList.toggle("opacity-0");
        });
    }

    // Date range dropdown functionality
    const dateRangeButton = document.getElementById('dateRangeButton');
    const dateRangeDropdown = document.getElementById('dateRangeDropdown');
    if (dateRangeButton && dateRangeDropdown) {
        dateRangeButton.addEventListener("click", function() {
            dateRangeDropdown.classList.toggle("hidden");
        });
    }
});
