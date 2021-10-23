<template>
  <div id="app">
    <h2>Campaigns</h2>
    <AllCampaigns/>
    <hr>
    <CreateCampain/>
  </div>
</template>

<script>
import AllCampaigns from './AllCampaigns.vue'
import CreateCampain from './CreateCampain.vue'
export default {
  components: { AllCampaigns, CreateCampain }
}
</script>