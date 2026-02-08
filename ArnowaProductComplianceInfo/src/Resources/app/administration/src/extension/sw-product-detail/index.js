Shopware.Component.override('sw-product-detail', {
  computed: {
    productCriteria() {
      // this adds the compliance info association to the product criteria
      const criteria = this.$super('productCriteria')
      criteria.addAssociation('complianceInfo')
      return criteria
    },
  },
})
