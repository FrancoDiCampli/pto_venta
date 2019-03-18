<template>
  <div class="container">
    <canvas id="myChart"></canvas>
    <line-chart :chart-data="datacollection"></line-chart>
    <button @click="fillData()">Randomize</button>
  </div>
</template>

<script>
import { Bar } from "vue-chartjs";
export default {
  extends: Bar,
  data() {
    return {
      test: "hola"
    };
  },
  methods: {},
  components: {
    "line-chart": LineChart
  },
  mounted() {
    this.renderChart(data, options);
  }
};
</script>

