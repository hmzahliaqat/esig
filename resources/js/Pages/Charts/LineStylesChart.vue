<template>
  <div class="card">
    <Chart type="line" :data="chartData" :options="chartOptions" class="h-[30rem]" />
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import Chart from "primevue/chart";

onMounted(() => {
  chartData.value = setChartData();
  chartOptions.value = setChartOptions();
});

const chartData = ref();
const chartOptions = ref();

const setChartData = () => {
  const documentStyle = getComputedStyle(document.documentElement);

  return {
    labels: ["January", "February", "March", "April", "May", "June", "July"],
    datasets: [
      {
        label: "First Dataset",
        data: [65, 59, 80, 81, 56, 55, 40],
        fill: false,
        tension: 0.4,
        borderColor: documentStyle.getPropertyValue("--p-cyan-500"),
      },
      {
        label: "Second Dataset",
        data: [28, 48, 40, 19, 86, 27, 90],
        fill: false,
        borderDash: [5, 5],
        tension: 0.4,
        borderColor: documentStyle.getPropertyValue("--p-orange-500"),
      },
      {
        label: "Third Dataset",
        data: [12, 51, 62, 33, 21, 62, 45],
        fill: true,
        borderColor: documentStyle.getPropertyValue("--p-gray-500"),
        tension: 0.4,
        backgroundColor: "rgba(107, 114, 128, 0.2)",
      },
    ],
  };
};
const setChartOptions = () => {
  const documentStyle = getComputedStyle(document.documentElement);
  const textColor = documentStyle.getPropertyValue("--p-text-color");
  const textColorSecondary = documentStyle.getPropertyValue("--p-text-muted-color");
  const surfaceBorder = documentStyle.getPropertyValue("--p-content-border-color");

  return {
    maintainAspectRatio: false,
    aspectRatio: 0.6,
    plugins: {
      legend: {
        labels: {
          color: textColor,
        },
      },
    },
    scales: {
      x: {
        ticks: {
          color: textColorSecondary,
        },
        grid: {
          color: surfaceBorder,
        },
      },
      y: {
        ticks: {
          color: textColorSecondary,
        },
        grid: {
          color: surfaceBorder,
        },
      },
    },
  };
};
</script>
