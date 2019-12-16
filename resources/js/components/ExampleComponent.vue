<template>
    <div class="small">
        <line-chart :chart-data="datacollection"></line-chart>
    </div>
</template>

<script>
import LineChart from './LineChart.js'

export default {
    props: ['hist'],
    components: {
        LineChart
    },
    data () {
        return {
            datacollection: null
        }
    },
    created () {
        console.log(this.hist);
    },
    mounted () {
        /*
        * call fillData(props) with history from props (laravel)
        */
        this.fillData(this.hist)
        Pusher.logToConsole = true;
            var pusher = new Pusher('02905f0e5b161db67caa', {
            cluster: 'eu',
            encrypted: true
        });
        /*
        * listen node and call fillData(node_history) with history from node
        */
        var channel = pusher.subscribe('node');
        channel.bind('ResponseToRequest', data => {
            console.log(data.docs)
            this.fillData(data.docs);
            //this.fillData(data.json_hist);
        });
    },
    methods: {
        // test_fill_data(data) {
        //     this.datacollection = {
        //         labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
        //         datasets: [
        //             {
        //                 label: 'test',
        //                 backgroundColor: 'rgba(241, 218, 242, 0.1)',
        //                 borderColor: 'rgba(241, 218, 242, 1)',
        //                 data: data
        //             }
        //         ]
        //     }
        // },
        fillData (hist_rate) {
            var new_lables = [];
            var new_data = {};
            var new_rate = [];
            /**
            * new_lables - array of time 
            */
            for(let i = 0; i < hist_rate.length; i++) {
                new_lables.push(hist_rate[i].time);
            }
            /**
            * new_data - object with code key and array of rates value
            * Object.keys(this.hist[0])[i] - currency code
            */
            for(let i = 0; i < Object.keys(hist_rate[0]).length; i++) {
                new_rate = [];
                if(Object.keys(hist_rate[0])[i] == 'time')
                    continue;
                for(let j = 0; j < hist_rate.length; j++) {
                    new_rate.push(hist_rate[j][Object.keys(hist_rate[0])[i]]);
                }
                new_data[Object.keys(hist_rate[0])[i]] = new_rate;
                console.log(new_rate);
            }
            this.datacollection = {
                labels: new_lables,
                datasets: [
                    /**
                    * uncomment or add new currencies
                    */

                    /*{
                        label: 'AUD',
                        backgroundColor: 'rgba(0, 0, 0, 0.0)',
                        data: new_data['AUD']
                    },*/
                    /*{
                        label: 'BGN',
                        backgroundColor: 'rgba(0, 0, 0, 0.0)',
                        data: new_data['BGN']
                    },*/
                    /*{
                        label: 'BRL',
                        backgroundColor: 'rgba(0, 0, 0, 0.0)',
                        data: new_data['BRL']
                    },*/
                    /*{
                        label: 'CAD',
                        backgroundColor: 'rgba(0, 0, 0, 0.0)',
                        data: new_data['CAD']
                    },*/
                    {
                        label: 'RUB',
                        backgroundColor: 'rgba(241, 218, 242, 0.1)',
                        borderColor: 'rgba(241, 218, 242, 1)',
                        data: new_data['RUB']
                    },
                    /*{
                        label: 'COP',
                        backgroundColor: 'rgba(0, 0, 0, 0.0)',
                        data: new_data['COP']
                    },*/
                    /*{
                        label: 'CZK',
                        backgroundColor: 'rgba(0, 0, 0, 0.0)',
                        data: new_data['CZK']
                    },*/
                    /*{
                        label: 'EUR',
                        backgroundColor: 'rgba(237, 242, 196, 0.1)',
                        borderColor: 'rgba(237, 242, 196, 1)',
                        data: new_data['EUR']
                    },*/
                    /*{
                        label: 'INR',
                        backgroundColor: 'rgba(0, 0, 0, 0.0)',
                        data: new_data['INR']
                    },*/
                    {
                        label: 'JPY',
                        backgroundColor: 'rgba(237, 242, 196, 0.1)',
                        borderColor: 'rgba(237, 242, 196, 1)',
                        data: new_data['JPY']
                    },
                    {
                        label: 'CNY',
                        backgroundColor: 'rgba(196, 242, 242, 0.1)',
                        borderColor: 'rgba(196, 242, 242, 1)',
                        data: new_data['CNY']
                    },
                ]
            }
        },
    }
}
</script>

<style>
.small {
    width: 500px;
    margin: 100px auto;
}
</style>