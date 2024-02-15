<?php

namespace _5balloons\LivewireTooltip;

use Livewire\Component;
use Livewire\Attributes\On;


/**   Usage
 *     <a class="tooltip-link" tooltip-method="\App\Directory\Class::methodName">Link Name</a>
 *     or
 *     <a class="tooltip-link" tooltip-method="\App\Directory\Class::methodName" data-param1="value">Link Name</a>
 */
class Tooltip extends Component
{
    public $toolTipMethod = null;
    public $toolTipHtml = null;

    public function render()
    {
        return <<<'HTML'
        <div>
            <style>
                #tooltip[data-show] {
                    display: block;
                    z-index: 100;
                }

                #tooltip {
                    display: none;
                    background-color: #333;
                    color: white;
                    padding: 5px 10px;
                    border-radius: 4px;
                    font-size: 14px;
                }
            </style>
            <div wire:ignore.self id="tooltip">
                <div class="flex">
                    <div wire:loading>
                        <div class="w-4 h-4 border-solid inline-block border-b-2 border-white rounded-full animate-spin"></div>
                    </div>  
                    <div>
                    {!! $toolTipHtml !!}
                    </div>
                </div>
            </div>
            @script
            <script>
                 let tooltipLinks = document.querySelectorAll('.tooltip-link');
                let tooltip = document.getElementById('tooltip');
                let popperInstance = null;

                tooltipLinks.forEach(el => {
                    el.addEventListener('mouseover', event => {
                        let placement = event.target.getAttribute('data-placement') || 'top'; // Default to 'top' if not specified

                        const popperInstance = Popper.createPopper(event.target, tooltip, {
                            placement: placement,
                            modifiers: [
                                {
                                    name: 'offset',
                                    options: {
                                        offset: [0, 8], // Adjust based on your needs
                                    },
                                },
                            ],
                        });

                        // Function to show tooltip
                        function showTooltip() {
                            tooltip.setAttribute('data-show', '');
                            tooltip.classList.remove('hidden');
                            popperInstance.update();
                        }

                        // Function to hide tooltip
                        function hideTooltip() {
                            tooltip.removeAttribute('data-show');
                            tooltip.classList.add('hidden');
                            if (popperInstance) {
                                popperInstance.destroy();
                            }
                        }

                        let classAndMethod = event.target.getAttribute('tooltip-method');
                        let params = {};
                        Object.entries(event.target.dataset).forEach(([key, value]) => {
                            if (key.startsWith('param')) {
                                params[key] = value;
                            }
                        });


                        // Dispatch event to fetch content
                        Livewire.dispatchTo('livewire-tooltip', 'tooltip-mouseover', {classAndMethod : classAndMethod, parameters: params});

                        // Show the tooltip
                        showTooltip();

                        el.addEventListener('mouseout', event => {
                            // Hide the tooltip
                            hideTooltip();
                        });

                    });

                    

                    
                });
            </script>
            @endscript
        </div>
        HTML;
    }

    #[On('tooltip-mouseover')] 
    public function fetchContent($classAndMethod, $parameters){

        // Split the class and method using '::' as the delimiter
        [$className, $methodName] = $this->parseClassAndMethodName($classAndMethod);
        
        //try{
            // Check if the class and method is callable
            if (is_callable([$className, $methodName])) {

                $paramValues = array_values($parameters);
                // Call the static method dynamically and store the result
                $result = call_user_func_array($classAndMethod, $paramValues);

                // Check if the result is a view instance
                if ($result instanceof \Illuminate\View\View) {
                    // Render the view to a string
                    $this->toolTipHtml = $result->render();
                } elseif (is_string($result)) {
                    // Use the string directly
                    $this->toolTipHtml = $result;
                } else {
                    // Handle other types of return values or set an error message
                    $this->toolTipHtml = 'Invalid content for tooltip.';
                }
            } else {
                // Method not callable, handle error
                $this->toolTipHtml = 'Error: Method not found or not callable.';
            }
        // }catch(\Exception $e){
        //     $this->toolTipHtml = 'Error fetching tooltip content';
        // }
    }

    #[On('tooltip-mouseout')]
    public function clearContent(){
        $this->toolTipHtml = '';
    } 


    protected function parseClassAndMethodName($tooltipMethod)
    {
        // Find the position of the first parenthesis (if any)
        $parenthesisPos = strpos($tooltipMethod, '(');
        
        // If there's no parenthesis, assume there are no parameters
        if ($parenthesisPos === false) {
            // Split by '::' to get class and method
            [$className, $methodName] = explode('::', $tooltipMethod);
        } else {
            // Extract the substring up to the first parenthesis
            $classAndMethod = substr($tooltipMethod, 0, $parenthesisPos);
            // Split by '::' to get class and method
            [$className, $methodName] = explode('::', $classAndMethod);
        }

        return [$className, $methodName];
    }

    
}
