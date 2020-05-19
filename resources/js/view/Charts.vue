<script>
        import {
            Line
        } from "vue-chartjs";

        export default {
            extends: Line,
            data() {
                return {
                    gradient: null,
                    gradient2: null,
                    data: [],
                    border_color: '#05CBE1',
                    labels : null,
                    label : 'Time',
                    gradientColor : null
                };
            },
            mounted() {  
                this.gradient = this.$refs.canvas
                    .getContext("2d")
                    .createLinearGradient(0, 0, 0, 450);

                this.gradient2 = this.$refs.canvas
                    .getContext("2d")
                    .createLinearGradient(0, 0, 0, 450);

                this.gradient.addColorStop(0, "rgba(255, 0,0, 0.5)");
                this.gradient.addColorStop(0.5, "rgba(255, 0, 0, 0.25)");
                this.gradient.addColorStop(1, "rgba(255, 0, 0, 0)");

                this.gradient2.addColorStop(0, "rgba(0, 231, 255, 0.9)");
                this.gradient2.addColorStop(0.5, "rgba(0, 231, 255, 0.25)");
                this.gradient2.addColorStop(1, "rgba(0, 231, 255, 0)");

                this.gradientColor = this.gradient2;

                this.render();
                this.generate_score('TIME');
            },


            methods: {

                render() {
                    this.renderChart({
                        labels: this.labels,
                        datasets: [{
                            label: this.label,
                            borderColor: this.border_color,
                            pointBackgroundColor: "white",
                            borderWidth: 1,
                            pointBorderColor: "white",
                            backgroundColor: this.gradientColor,
                            data: this.data
                        }]
                    }, {
                        responsive: true,
                        maintainAspectRatio: false
                    });
                },

                generate_score(value) {
                    axios.get(`/api/get-score?type=${value}`).then(response => {

                        if(value == 'TIME') {
                            this.gradientColor = this.gradient2;
                            this.label = 'TIME';
                            this.border_color = "#05CBE1";
                        } else {
                            this.gradientColor = this.gradient;
                            this.label = 'DAYS';
                            this.border_color = "#FC2525";
                        }

                        this.data = response.data.data
                        this.labels = response.data.label
                        this.render()
                    })
                }
            },
        };

</script>