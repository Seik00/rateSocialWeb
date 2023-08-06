<template>
    <div class="mx-4 d-flex flex-column flex-grow-1 pb-5" style="height: 100vh">
        <div class="appBar">
            <span>{{ $t("market") }}</span>
        </div>
        <Market :isHome="false"></Market>

    </div>
</template>

<script>
import Market from "./modules/tradeMarket.vue"
export default {
    components: { Market }

}
</script>