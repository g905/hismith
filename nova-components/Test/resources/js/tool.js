Nova.booting((Vue, router, store) => {
    router.addRoutes([
        {
            name: 'parse_news',
            path: '/parse',
            component: require('./components/Tool'),
        },
    ])
})
