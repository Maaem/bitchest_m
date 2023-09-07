import { useLoader } from "@tanstack/react-router";
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
} from "chart.js";
import { Line } from "react-chartjs-2";
import { Flex } from "@chakra-ui/react";

import { convertApiDataToChartJsFormat } from "@/helpers";

ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend);

export const CurrencyRate = () => {
  /**
   *
   * @type {{id:string,crypto_name:string,currency_histories:[{id:number,quoting:number,date:string}]}}
   */
  const currencyRate = useLoader();

  const { labels, chartData } = convertApiDataToChartJsFormat(currencyRate);

  const data = {
    labels,
    datasets: [
      {
        label: currencyRate.crypto_name,
        data: chartData,
        borderColor: "#90CDF4",
        backgroundColor: "#2C5282",
      },
    ],
  };

  const options = {
    responsive: true,
    plugins: {
      legend: {
        position: "top",
      },
      title: {
        display: true,
        text: currencyRate.crypto_name,
      },
    },
  };

  return (
    <>
      <Flex
        justifyContent={"center"}
        alignItems={"center"}
        height={"100%"}
        p={5}
        mt={["5rem", "5rem", "0rem"]}>
        <Line options={options} data={data} />
      </Flex>
    </>
  );
};
