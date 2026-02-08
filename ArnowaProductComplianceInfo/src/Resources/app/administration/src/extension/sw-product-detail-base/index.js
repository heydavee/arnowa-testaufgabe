// reference: https://developer.shopware.com/docs/guides/plugins/plugins/administration/module-component-management/customizing-components.html

import template from './sw-product-detail-base.html.twig'

Shopware.Component.override('sw-product-detail-base', {
  template,

  watch: {
    product: {
      immediate: true,
      handler(product) {
        if (product && product.id) {
          this.ensureComplianceInfoExtension()
        }
      },
    },
  },

  computed: {
    complianceInfo() {
      return this.product?.extensions?.complianceInfo ?? null
    },
  },

  methods: {
    getProductVersionId() {
      return this.product?.versionId || Shopware.Context.api.versionId
    },

    // Returns the compliance info repository
    complianceRepository() {
      return this.repositoryFactory.create('arnowa_product_compliance_info')
    },

    // Creates a new compliance info entity with default values
    createComplianceEntity() {
      const entity = this.complianceRepository().create(Shopware.Context.api)
      entity.productId = this.product.id
      entity.productVersionId = this.getProductVersionId()
      entity.complianceRequired = false
      entity.complianceText = null

      return entity
    },

    ensureComplianceInfoExtension() {
      if (!this.product) {
        return
      }

      if (!this.product.extensions) {
        if (this.$set) {
          this.$set(this.product, 'extensions', {})
        } else {
          this.product.extensions = {}
        }
      }

      if (this.product.extensions.complianceInfo) {
        this.product.extensions.complianceInfo.productId = this.product.id
        this.product.extensions.complianceInfo.productVersionId =
          this.getProductVersionId()
        return
      }

      const entity = this.createComplianceEntity()

      if (this.$set) {
        this.$set(this.product.extensions, 'complianceInfo', entity)
      } else {
        this.product.extensions.complianceInfo = entity
      }
    },
  },
})
