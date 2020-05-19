<template>
    <div class="mt-10">
        <h1 class="text-2xl font-semibold text-center">Random Score Generator with Analitycs</h1>
        <div class="w-full flex mt-20 px-5">
            <div class="w-1/5 mt-8">
                <div class="flex justify-center">
                    <button @click="generateScore" class="p-2 rounded bg-green-500 text-white font-semibold">Generate
                        Score</button>
                </div>
                <div class="flex justify-center">
                    <button @click="time('TIME')"
                        class="py-2 px-3 rounded bg-blue-500 text-white font-semibold my-3">Time
                        Analitycs</button>
                </div>
                <div class="flex justify-center">
                    <button @click="days('DAY')" class="py-2 px-3 rounded bg-red-500 text-white font-semibold">Days
                        Analitycs</button>
                </div>

            </div>

            <div class="w-4/5">
                <area-chart ref="chart"></area-chart>
            </div>
        </div>
    </div>
</template>
<script>
    import AreaChart from "./Charts.vue";
    export default {
        components: {
            AreaChart
        },
        data() {
            return {
                type: 'TIME'
            };
        },

        methods: {
            generateScore() {
                axios.get('/api/generate-score').then(response => {
                    this.$refs.chart.generate_score(this.type)
                })
            },
            time(value) {
                this.type = value
                this.$refs.chart.generate_score(this.type)
            },
            days(value) {
                this.type = value
                this.$refs.chart.generate_score(this.type)
            }
        },

    }

</script>
