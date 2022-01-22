import { extend, } from 'vee-validate'
import { required, max, email, numeric, } from 'vee-validate/dist/rules'

extend('url', {
  validate: (value) => {
    if (value) {
      return /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\\-\\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(value)
    }
    
    return false
  },
  message: 'This value must be a valid URL',
})
extend('extPdf', {
  validate: (val) => {
    var exts = val[0].type.split('/')
    if (exts.slice(-1)[0] == 'pdf') {
      return true
    }
    
    return false
  },
  message: 'This field must be a valid pdf',
})
extend('email', {
  ...email,
  message: 'This field must be a valid email',
})
extend('numeric', {
  ...numeric,
  message: 'This field must be a valid numeric',
})
extend('required', {
  ...required,
  message: 'This {_field_} is required',
})
extend('max', {
  ...max,
  message: 'This {_field_} Max {length}',
})
extend('min', {
  ...max,
  message: 'This {_field_} Min {length}',
})
extend('requiredPassword', {
  ...required,
  message: 'This password is required',
})
extend('minLength', {
  validate(value, args) {
    const length = value.length
    
    return length >= args.min
  },
  params: ['min'],
  message: 'This {_field_} min {min}',
})
