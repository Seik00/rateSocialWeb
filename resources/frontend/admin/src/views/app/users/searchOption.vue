<template>
  <div>
    <input
      :id="index"
      type="text"
      class="form-control"
      readonly
      @click="showModal"
      v-model="productText"
    />
    <b-modal
      :id="'modal-search' + index"
      size="md"
      centered
      :title="$t('products_price') + ' No' + (index + 1)"
      @ok="handleOk"
    >
      <input
        type="number"
        class="form-control"
        v-model="price"
        min="0"
        step="0.01"
        @input="loadItems"
        :placeholder="$t('inputPrice')"
      />
      <div
        class="mt-4"
        style="height: 300px; position: relative; overflow-y: scroll"
      >
        <div
          v-if="isSearching || productList.length <= 0"
          style="
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            height: 100%;
            width: 100%;
            z-index: 3;
            display: flex;
            justify-content: center;
            align-items: center;
          "
        >
          <div
            v-if="isSearching"
            class="spinner spinner-primary m-2 text-50"
          ></div>
          <div v-else-if="productList.length <= 0">
            <span>{{ $t("nodataInPrice") }}</span>
          </div>
          <!-- <br />
          <span
            style="
              background-color: #c0dfff;
              color: #409eff;
              padding: 7px 30px;
              border-radius: 3px;
            "
            >{{ $t("loading...") }}</span
          > -->
        </div>

        <b-list-group>
          <b-list-group-item
            @click="selectProduct(item)"
            button
            v-for="item in productList"
            :key="item.id"
            >{{ "(" + item.price + ") " + item.name }}</b-list-group-item
          >
        </b-list-group>
      </div>
    </b-modal>
  </div>
</template>

<script>
import { searchByPrice } from "../../../system/api/api";
import { handleError } from "../../../system/handleRes";
import { mapGetters } from "vuex";
export default {
  props: ["index", "products", "id"],
  computed: {
    ...mapGetters(["lang"]),
    productText() {
      if (this.id != null && this.id != "") {
        var tmp = "";
        for (let i = 0; i < this.products.length; i++) {
          if (this.products[i].value == this.productID) {
            tmp = this.products[i].text;
          }else if(this.products[i].value == this.id){
            tmp = this.products[i].text;

          }
        }
        return tmp;
      } else {
        return null;
      }
    },
  },
  data() {
    return {
      // productText: "",
      isSearching: true,
      isClicked: false,
      price: "",
      productList: [],
      productID: null,
      preProductID: null,
    };
  },
  methods: {
    handleOk() {
      console.log("clicked");
      var jsonObject = {};
      this.isClicked = true;
      this.productID = this.preProductID;

      // this.productText = this.products[this.productID].text;
      jsonObject["index"] = this.index;
      jsonObject["productID"] = this.productID;
      this.$emit("_productID", jsonObject);
    },
    selectProduct(item) {
      this.preProductID = item.id;
    },
    showModal() {
      this.isClicked = false;
      this.$bvModal.show("modal-search" + this.index);
      this.loadItems();
    },
    loadItems() {
      this.productList = [];
      var result = searchByPrice(this.price);
      var self = this;
      this.isSearching = true;
      result
        .then(function (value) {
          self.productList = value.data.data.record;
          self.isSearching = false;
        })
        .catch(function (error) {
          self.$refs.msg.makeToast("warning", self.$t(handleError(error)));
        });
    },
  },
  created() {},
};
</script>