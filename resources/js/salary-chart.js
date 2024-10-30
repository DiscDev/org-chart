import Chart from 'chart.js/auto';

document.addEventListener('alpine:init', () => {
    Alpine.data('salaryChart', () => ({
        chart: null,
        init() {
            this.initChart();
            this.$watch('chartData', () => {
                this.updateChart();
            });
        },
        initChart() {
            const ctx = this.$refs.chart.getContext('2d');
            this.chart = new Chart(ctx, {
                type: 'bar',
                data: this.getChartData(),
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return '$' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        },
        getChartData() {
            return {
                labels: this.chartData.map(item => item.name),
                datasets: [
                    {
                        label: 'Base Salary',
                        data: this.chartData.map(item => item.avg_salary),
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 1
                    },
                    {
                        label: 'Total Cost (inc. Agency Fees)',
                        data: this.chartData.map(item => item.avg_total_salary),
                        backgroundColor: 'rgba(139, 92, 246, 0.5)',
                        borderColor: 'rgb(139, 92, 246)',
                        borderWidth: 1
                    }
                ]
            };
        },
        updateChart() {
            if (this.chart) {
                this.chart.data = this.getChartData();
                this.chart.update();
            }
        }
    }));
});