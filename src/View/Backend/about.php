<?php
/**
 * Backend Page Setting - About Page
 */
$config = $this->Plugin->getConfig();
?>

<div class="-mx-2 my-2 px-2">

    <main class="grid grid-cols-1 md:grid-cols-5 my-2 w-full bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="bg-cover-image shadow-sm bg-center bg-cover px-6 py-16">
            <div class="w-3/4 mx-auto">
                <img
                    class="mx-auto animate__animated animate__<?php echo esc_attr( $options->fab_animation->elements->logo ); ?>"
                    src="<?php echo esc_url( json_decode( FAB_PATH )->plugin_url ); ?>/assets/img/logo.png"
                    alt="<?php echo esc_attr( $this->Page->getPageTitle() ); ?>"
                >
            </div>
        </div>

        <div class="col-span-4 mx-8 md:mx-16 my-12">
            <h2 class="text-3xl md:text-5xl font-medium mb-4">
                <?php echo esc_attr( $this->Plugin->getName() ); ?>
            </h2>

            <div class="flex items-center">
                <div class="text-sm inline-flex items-center leading-sm px-4 py-1 mb-4 bg-primary-600 text-white rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mt-0.5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                    </svg>
                    <?php $url = isset($config->url->wordpress) ? $config->url->wordpress : '#'; ?>
                    <a href="<?php echo esc_url($url); ?>" <?php if($url!='#') echo 'target="_blank"'; ?>>
                        <?php echo esc_attr( $this->Plugin->getVersion() ); ?>
                    </a>
                </div>
                <?php $url = isset($config->url->contact) ? $config->url->contact : '#'; ?>
                <a href="<?php echo esc_url($url); ?>" target="_blank" class="text-sm inline-flex items-center leading-sm px-4 py-1 mb-4 ml-2 bg-primary-600 text-white rounded-full">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Contact
                </a>
                <a href="https://www.youtube.com/watch?v=MMuhc9pcYew&list=PLnwuifVLRkaXBV9IBTPZeLtduzCdt5cFh" target="_blank" class="text-sm inline-flex items-center leading-sm px-4 py-1 mb-4 ml-2 bg-red-600 text-white rounded-full">
                    <i class="fab fa-youtube mr-2"></i>
                    Documentation
                </a>
                <a href="https://www.youtube.com/watch?v=CkSspyM9yjQ&list=PLnwuifVLRkaXH9I-QAAReVoEv9DClViPG" target="_blank" class="text-sm inline-flex items-center leading-sm px-4 py-1 mb-4 ml-2 bg-red-600 text-white rounded-full">
                    <i class="fab fa-youtube mr-2"></i>
                    Tutorial
                </a>
            </div>

            <p class="text-lg">
                <?php echo ( esc_attr( $this->Plugin->getConfig()->description ) ) ? esc_attr($this->Plugin->getConfig()->description) : ''; ?>
            </p>
        </div>

    </main>

</div>