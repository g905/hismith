<template>
    <div>
        <heading class="mb-6">Parse News</heading>

<button v-on:click="parseNews" class="btn btn-default btn-primary inline-flex items-center relative mr-3">Make new request</button>
<div v-if="result">Request {{ result.success ? "successful" : "failed" }}</div>
<div v-if="result">Added {{result.count}} new items</div>

    </div>
</template>

<script>
export default {
    metaInfo() {
        return {
          title: 'Parse News',
        }
    },
    mounted() {
        //
    },
data() {
    return {
        result: null
    }
},
methods: {
    parseNews() {
        axios.get('/api/parse_news').then((response)=>{this.result = response.data.result})
    }
}
}
</script>

<style>
/* Scoped Styles */
</style>
