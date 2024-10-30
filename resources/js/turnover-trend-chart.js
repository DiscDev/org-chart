document.addEventListener('alpine:init', () => {
    Alpine.data('turnoverTrendChart', () => ({
        chart: null,
        initChart(data) {
            const ctx = this.$refs.chart.getContext('2d');
            
            if (this.chart) {
                this.chart.destroy();
            }

            this.chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.map(d => d.month),
                    datasets: [
                        {
                            label: 'Turnover Rate (%)',
                            data: data.map(d => d.turnover_rate),
                            borderColor: 'rgb(99, 102, 241)',
                            backgroundColor: 'rgba(99, 102, 241, 0.1)',
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Departures',
                            data: data.map(d => d.departures),
                            borderColor: 'rgb(244, 63, 94)',
                            backgroundColor: 'rgba(244, 63, 94, 0.1)',
                            tension: 0.3,
                            fill: true,
                            yAxisID: 'departures'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Turnover Rate (%)'
                            }
                        },
                        departures: {
                            position: 'right',
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Departures'
                            },
                            grid: {
                                drawOnChartArea: false
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    }
                }
            });
        }
    }));
});