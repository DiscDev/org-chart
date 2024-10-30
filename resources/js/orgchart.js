import OrgChart from '@balkangraph/orgchart.js';

document.addEventListener('alpine:init', () => {
    Alpine.data('orgChart', () => ({
        chart: null,
        init() {
            this.initChart();
            this.$watch('nodes', () => {
                this.updateChart();
            });
        },
        initChart() {
            this.chart = new OrgChart(this.$refs.tree, {
                template: "olivia",
                enableDragDrop: false,
                nodeBinding: {
                    field_0: "name",
                    field_1: "title",
                    img_0: "photo"
                },
                nodes: this.formatNodes(this.nodes)
            });
        },
        formatNodes(nodes, parentId = null) {
            return nodes.flatMap(node => {
                const formattedNode = {
                    id: node.id,
                    pid: parentId,
                    name: node.name,
                    title: node.title,
                    photo: node.photo || '',
                    tags: [...node.departments, ...node.teams, ...node.roles]
                };

                const children = node.children ? this.formatNodes(node.children, node.id) : [];
                return [formattedNode, ...children];
            });
        },
        updateChart() {
            if (this.chart) {
                this.chart.load(this.formatNodes(this.nodes));
            }
        }
    }));
});